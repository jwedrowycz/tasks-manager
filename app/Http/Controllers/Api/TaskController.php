<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return TaskResource::collection(Task::active()->latest()->with('user')->withFilters()->paginate(10));
    }

    public function show($id)
    {
        return new TaskResource(Task::findOrFail($id));
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create([
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'start'        => $validated['start'],
            'is_private'   => $validated['is_private'],
            'is_active'    => true,
            'expected_end' => $validated['expected_end'],
            'user_id'      => auth()->id()
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {   
        if($task->user_id != auth()->id())
        {
            abort(403);
        }
        $task->update($request->all());
        return response()->json($task, 200);
    }

    public function complete(Task $task)
    {
        $task->update(['end' => date('Y-m-d H:i:s')]);

        return response()->json($task, 200);
    }

    public function destroy(Task $task)
    {
        if($task->user_id != auth()->id())
        {
            abort(403);
        }

        $task->delete();
        return response()->json(null, 204);
    }
}
