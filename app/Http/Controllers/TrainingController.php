<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    /**
     * Listar todos os treinamentos.
     */
    public function index()
    {
        $trainings = Training::with([
            'type', 'client', 'instructor', 'status', 'financialStatus', 'costs', 'resources', 'post_training',
        ])->get();

        return response()->json($trainings);
    }

    /**
     * Criar novo treinamento.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'description' => 'required|string',
            'qtd_student' => 'required|integer|min:1',
            'type_training_name' => 'required|string|exists:type_trainings,type',
            'client_name' => 'required|string|exists:clients,name',
            'instructor_name' => 'required|string|exists:instructors,name',
            'status_name' => 'required|string|exists:statuses,status',
            'financial_status_name' => 'required|string|exists:financial_statuses,status',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $typeTraining = \App\Models\TypeTraining::where('type', $request->type_training_name)->first();
        $client = \App\Models\Client::where('name', $request->client_name)->first();
        $instructor = \App\Models\Instructor::where('name', $request->instructor_name)->first();
        $status = \App\Models\Status::where('status', $request->status_name)->first();
        $financialStatus = \App\Models\FinancialStatus::where('status', $request->financial_status_name)->first();

        if (!$typeTraining || !$client || !$instructor || !$status || !$financialStatus) {
            return response()->json(['error' => 'Registro relacionado não encontrado.'], 422);
        }

        $data = $request->only([
            'title',
            'due_date',
            'description',
            'qtd_student',
        ]);

        // Substituir pelos IDs relacionados
        $data['type_training_id'] = $typeTraining->id;
        $data['client_id'] = $client->id;
        $data['instructor_id'] = $instructor->id;
        $data['status_id'] = $status->id;
        $data['financial_status_id'] = $financialStatus->id;

        // Associar o usuário logado (se for o caso)
        $data['user_id'] = auth()->id();

        $training = Training::create($data);

        return response()->json($training, 201);
    }

    /**
     * Exibir um treinamento.
     */
    public function show($id)
    {
        $training = Training::with([
            'type', 'client', 'instructor', 'status', 'financialStatus', 'costs', 'resources', 'post_training',
        ])->findOrFail($id);

        return response()->json($training);
    }

    /**
     * Atualizar um treinamento.
     */
    public function update(Request $request, $id)
    {
        $training = Training::findOrFail($id);

        $data = $request->only([
            'title',
            'due_date',
            'description',
            'qtd_student',
        ]);

        // Busca os IDs relacionados
        $typeTraining = \App\Models\TypeTraining::where('type', $request->type_training_name)->first();
        $client = \App\Models\Client::where('name', $request->client_name)->first();
        $instructor = \App\Models\Instructor::where('name', $request->instructor_name)->first();
        $status = \App\Models\Status::where('status', $request->status_name)->first();
        $financialStatus = \App\Models\FinancialStatus::where('status', $request->financial_status_name)->first();

        if (!$typeTraining || !$client || !$instructor || !$status || !$financialStatus) {
            return response()->json(['error' => 'Registro relacionado não encontrado.'], 422);
        }

        $data['type_training_id'] = $typeTraining->id;
        $data['client_id'] = $client->id;
        $data['instructor_id'] = $instructor->id;
        $data['status_id'] = $status->id;
        $data['financial_status_id'] = $financialStatus->id;

        $training->update($data);

        return response()->json($training);
    }

    /**
     * Remover um treinamento.
     */
    public function destroy($id)
    {
        $training = Training::findOrFail($id);

        // Verifica se o treinamento pertence ao usuário logado
        if ($training->user_id !== auth()->id()) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }

        $training->delete();

        return response()->json(['message' => 'Treinamento removido com sucesso.']);
    }
}
