<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Training $training)
    {
        $resource = $training->resources()->withPivot('id', 'due_date', 'comment')->get();

        return response()->json($resource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Training $training)
    {
        $data = $request->validate([
        'resource_name' => 'required|string|exists:resources,title',
        'due_date' => 'required|date',
        'comment' => 'nullable|string',
    ]);

        $resource = Resource::where('title', $data['resource_name'])->firstOrFail();

        // Verifica se já existe reserva para o recurso na mesma data
        $conflict = DB::table('booking_resources')
            ->where('resource_id', $resource->id)
            ->where('due_date', $data['due_date'])
            ->exists();

        if ($conflict) {
            return response()->json([
                'error' => 'Recurso já reservado para este dia.',
            ], 409);
        }

        // Cria a reserva
        $training->resources()->attach($resource->id, [
            'due_date' => $data['due_date'],
            'comment' => $data['comment'] ?? null,
        ]);

        return response()->json([
            'message' => 'Recurso reservado com sucesso.',
            'resource_id' => $resource->id,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Training $training, $resourceId)
    {
        $data = $request->validate([
        'due_date' => 'required|date',
        'comment' => 'nullable|string',
    ]);

        // Verifica se já existe reserva para o mesmo recurso e data,
        // exceto a reserva atual (pivot) que estamos atualizando
        $conflict = DB::table('booking_resources')
            ->where('resource_id', $resourceId)
            ->where('due_date', $data['due_date'])
            ->where('training_id', '!=', $training->id)  // Ignora o registro atual
            ->exists();

        if ($conflict) {
            return response()->json([
                'error' => 'Recurso já reservado para este dia.',
            ], 409);
        }

        // Atualiza os dados na tabela pivô
        $training->resources()->updateExistingPivot($resourceId, [
            'due_date' => $data['due_date'],
            'comment' => $data['comment'] ?? null,
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Reserva atualizada com sucesso.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training, $bookingResourceId)
    {
        // Busca o registro pivô pelo ID da tabela booking_resources
        $bookingResource = DB::table('booking_resources')
            ->where('id', $bookingResourceId)
            ->first();

        if (!$bookingResource) {
            return response()->json(['error' => 'Reserva não encontrada.'], 404);
        }

        // Desvincula o resource do training usando resource_id real
        $training->resources()->detach($bookingResource->resource_id);

        return response()->json(['message' => 'Reserva removida com sucesso.'], 200);
    }
}
