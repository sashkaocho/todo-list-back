<?php

namespace App\Http\Controllers;

use App\Events\TaskReminder;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Jobs\SendTaskReminder;
use App\Models\Task;
use Carbon\Carbon;
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

        // couldn't calculate delay time
        $start_time = strtotime($task->start_date);

        SendTaskReminder::dispatch($task)->delay(now()->addSeconds($start_time - strtotime("+5 minutes")));

        return response()->json(['success' => true, 'message' => [$start_time - strtotime("+5 minutes")]]);
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

        SendTaskReminder::dispatch($task)->delay(Carbon::parse($task->datetime)->subMinutes(5));

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
