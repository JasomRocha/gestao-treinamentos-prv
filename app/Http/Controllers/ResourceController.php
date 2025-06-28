<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resource = Resource::all();

        return response()->json($resource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $resource = Resource::create($data);

        return response()->json($resource, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resource = Resource::with([])->findOrFail($id);

        return response()->json($resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $resource = Resource::findOrFail($id);

        $resource->update($request->all());

        return response()->json($resource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resource = Resource::findOrFail($id);

        $resource->delete();

        return response()->json(['message' => 'Custo removido com sucesso.']);
    }
}
