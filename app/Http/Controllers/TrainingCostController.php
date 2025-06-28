<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingCostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Training $training)
    {
        $costs = $training->costs()->withPivot('id', 'quantity', 'final_value')->get();

        return response()->json($costs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Training $training)
    {
        $data = $request->validate([
            'cost_name' => 'required|string|exists:costs,title',
            'quantity' => 'required|integer|min:1',
        ]);

        // Busca o custo pelo título (nome)
        $cost = Cost::where('title', $data['cost_name'])->firstOrFail();

        // Calcula o valor final
        $finalValue = $data['quantity'] * $cost->value_unit;

        // Faz o vínculo na tabela pivô
        $training->costs()->attach($cost->id, [
            'quantity' => $data['quantity'],
            'final_value' => $finalValue,
        ]);

        return response()->json([
            'message' => 'Custo vinculado com sucesso.',
            'cost_id' => $cost->id,
            'final_value' => $finalValue,
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
    public function update(Request $request, Training $training, $training_cost_id)
    {
        $data = $request->validate([
        'quantity' => 'required|integer|min:1',
        ]);

        // Busca o registro pivô
        $trainingCost = DB::table('training_costs')->where('id', $training_cost_id)->first();

        if (!$trainingCost) {
            return response()->json(['error' => 'Registro não encontrado.'], 404);
        }

        // Busca o custo pra pegar o valor unitário
        $cost = Cost::findOrFail($trainingCost->cost_id);

        $finalValue = $data['quantity'] * $cost->value_unit;

        // Atualiza pivô (usando o cost_id que está vinculado)
        $training->costs()->updateExistingPivot(
            $trainingCost->cost_id,
            [
                'quantity' => $data['quantity'],
                'final_value' => $finalValue,
            ]
        );

        return response()->json([
            'message' => 'Custo atualizado com sucesso.',
            'final_value' => $finalValue,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training, $training_cost_id)
    {
        // Busca o registro pivô pra saber o cost_id
        $trainingCost = DB::table('training_costs')->where('id', $training_cost_id)->first();

        if (!$trainingCost) {
            return response()->json(['error' => 'Registro não encontrado.'], 404);
        }

        $training->costs()->detach($trainingCost->cost_id);

        return response()->json(['message' => 'Custo desvinculado com sucesso.']);
    }
}
