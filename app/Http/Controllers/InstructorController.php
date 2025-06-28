<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructor = Instructor::with([
            'user', 'trainings',
        ])->get();

        return response()->json($instructor);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Insere o user_id automaticamente
        $data = $request->all();
        $data['user_id'] = auth()->id(); // ou auth()->user()->id

        $instructor = Instructor::create($data);

        return response()->json($instructor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instructor = Instructor::with([
        'user',
        'trainings',
        ])->findOrFail($id);

        return response()->json($instructor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $instructor = Instructor::findOrFail($id);

        // Verifica se o instrutor pertence ao usuário logado
        if ($instructor->user_id !== auth()->id()) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }

        $instructor->update($request->all());

        return response()->json($instructor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instructor = Instructor::findOrFail($id);

        // Verifica se o instrutor pertence ao usuário logado
        if ($instructor->user_id !== auth()->id()) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }

        $instructor->delete();

        return response()->json(['message' => 'Instrutor removido com sucesso.']);
    }
}
