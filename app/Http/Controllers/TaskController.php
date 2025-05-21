<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string']);
        return Task::create(['title' => $request->title]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }

    public function show(Task $task)
    {
        return $task;  // Laravel will automatically return JSON of this task
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'completed' => 'boolean'
        ]);

        $task->update($validated);
        return redirect()->route('tasks.edit', $task)->with('success', 'Task updated successfully.');
    }
}
