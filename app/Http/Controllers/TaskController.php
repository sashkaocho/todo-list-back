<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::all();

        return response()->json($tasks);
    }

    public function store(CreateTaskRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $task = Task::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Task created successfully']);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $validatedData = $request->validated();

        if (isset($validatedData['name'])) {
            $task->name = $validatedData['name'];
        }

        if (isset($validatedData['description'])) {
            $task->description = $validatedData['description'];
        }

        if (isset($validatedData['start_date'])) {
            $task->start_date = $validatedData['start_date'];
        }

        if (isset($validatedData['end_date'])) {
            $task->end_date = $validatedData['end_date'];
        }

        $task->save();

        return response()->json(['success' => true, 'message' => 'Task updated successfully']);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(['success' => true, 'message' => 'Task deleted successfully']);
    }

    public function updateStatus(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $validatedData = $request->validate(['status' => 'string|required']);

        $task->status = $validatedData['status'];

        $task->save();

        return response()->json(['success' => true, 'message' => 'Task updated successfully']);
    }
}
