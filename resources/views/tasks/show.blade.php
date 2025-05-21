<!-- resources/views/tasks/show.blade.php -->
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
    <div class="task-container">
        <h2>{{ $task->title }}</h2>
        <p><span class="label">Description:</span> {{ $task->description ?? 'No description' }}</p>
        <p><span class="label">Due Date:</span> {{ $task->due_date ?? 'No due date' }}</p>
        <p><span class="label">Status:</span> {{ $task->completed ? 'Completed' : 'Incomplete' }}</p>
        <p><a href="/">← Back to Task List</a></p>
    </div>
</body>
</html>
