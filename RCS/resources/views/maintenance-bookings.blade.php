<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Bookings</title>
</head>
<body>
    <h1>Maintenance Bookings</h1>

    <!-- Display existing bookings -->
    <h2>List of Bookings</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Task</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr>
                    <td>{{ $booking->date }}</td>
                    <td>{{ $booking->time }}</td>
                    <td>{{ $booking->task }}</td>
                    <td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <!-- Booking form -->
    <form action="{{ url('maintenance-bookings') }}" method="POST">
    @csrf
    <label for="date">Date:</label>
    <input type="date" name="date" required>

    <label for="time">Time:</label>
    <input type="time" name="time" required>

    <label for="task">Task:</label>
    <select name="task" required>
        <option value="" disabled selected>Select a task</option>
        @foreach ($complaints as $complaint)
            <option value="{{ $complaint->id }}">
                {{ $complaint->resource_type }} - {{ $complaint->block_name }} - {{ $complaint->room }}
            </option>
        @endforeach
    </select>

    <button type="submit">Book Maintenance</button>
</form>
</body>
</html>
