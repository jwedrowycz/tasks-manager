<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return TaskResource::collection(Task::latest()->with('user')->get());
    }

    public function show($id)
    {
        return new TaskResource(Task::findOrFail($id));
    }

    public function store(Request $request)
    {
        $task = Task::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'start'        => date('Y-m-d H:i:s'),
            'end'          => date('Y-m-d H:i:s'),
            'is_private'   => false,
            'is_active'    => true,
            'expected_end' => date('Y-m-d H:i:s'),
            'user_id'         => auth()->id()
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return response()->json($task, 200);
    }

    public function delete(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
