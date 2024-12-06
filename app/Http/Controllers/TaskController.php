<?php

namespace App\Http\Controllers;

use App\Models\Task; // Assurez-vous que le modèle existe
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Obtenir toutes les tâches
     */
    public function index()
    {
        $tasks = Task::all(); // Récupère toutes les tâches
        return response()->json($tasks);
    }

    /**
     * Ajouter une nouvelle tâche
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|integer|min:1|max:5',
            'due_date' => 'required|date',
        ]);

        $task = Task::create($validated);
        return response()->json($task, 201); // Retourne la tâche créée avec le code 201
    }

    /**
     * Obtenir une tâche spécifique
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    /**
     * Mettre à jour une tâche existante
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'priority' => 'sometimes|required|integer|min:1|max:5',
            'due_date' => 'sometimes|required|date',
            'is_completed' => 'sometimes|required|boolean',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    /**
     * Supprimer une tâche
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();    
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
