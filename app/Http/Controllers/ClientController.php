<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with([
            'user', 'trainings',
        ])->get();

        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cnpj' => 'required|unsignedBigInteger|digits:14',
            'person' => 'required|string',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Insere o user_id automaticamente
        $data = $request->all();
        $data['user_id'] = auth()->id(); // ou auth()->user()->id

        $client = Client::create($data);

        return response()->json($client, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::with([
        'user',
        'trainings',
        ])->findOrFail($id);

        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        // Verifica se o cliente pertence ao usuário logado
        if ($client->user_id !== auth()->id()) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }

        $client->update($request->all());

        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);

        // Verifica se o cliente pertence ao usuário logado
        if ($client->user_id !== auth()->id()) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }

        $client->delete();

        return response()->json(['message' => 'Ciente removido com sucesso.']);
    }
}
