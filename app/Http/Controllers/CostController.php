<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costs = Cost::all();

        return response()->json($costs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'value_unt' => 'required|integer|min:1',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $cost = Cost::create($data);

        return response()->json($cost, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cost = Cost::with([])->findOrFail($id);

        return response()->json($cost);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cost = Cost::findOrFail($id);

        $cost->update($request->all());

        return response()->json($cost);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cost = Cost::findOrFail($id);

        $cost->delete();

        return response()->json(['message' => 'Custo removido com sucesso.']);
    }
}
