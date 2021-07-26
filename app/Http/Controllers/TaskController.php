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
        return TaskResource::collection(Task::all());
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
            'start'        => Carbon::now(),
            'end'          => Carbon::now(),
            'is_private'   => false,
            'expected_end' => Carbon::now(),
            'created_at'   => date('d-m-Y H:i', strtotime($this->created_at)),
            'user'         => auth()->id()
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
