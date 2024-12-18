<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>
    <h1>Hello {{ $task->teacher->name }},</h1>
    <p>A new task has been assigned to you:</p>
    <ul>
        <li><strong>Title:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description }}</li>
        <li><strong>Due Date:</strong> {{ $task->due_date }}</li>
    </ul>
    <p>Thank you.</p>
</body>
</html>
