<!DOCTYPE html>
<html>
<head>
    <title>Task Details - {{ $task->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
        }
        .task-container {
            border: 1px solid #ccc;
            padding: 2rem;
            border-radius: 8px;
            max-width: 600px;
        }
        h2 {
            margin-top: 0;
        }
        .label {
            font-weight: bold;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Task</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')

            <div>
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $task->title) }}" required>
            </div>

            <div>
                <label>Description</label>
                <textarea name="description">{{ old('description', $task->description) }}</textarea>
            </div>

            <div>
                <label>Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
            </div>

            <div>
                <label>
                    <input type="checkbox" name="completed" value="1" {{ $task->completed ? 'checked' : '' }}>
                    Completed
                </label>
            </div>

            <button type="submit">Update Task</button>
            <a href = "/">Back</a>
        </form>
    </div>
</body>
</html>
