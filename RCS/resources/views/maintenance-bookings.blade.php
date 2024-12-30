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
            <th>Block Name</th>
            <th>Room</th>
            <th>Priority</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($bookings as $booking)
        <tr>
            <td>{{ $booking->date }}</td>
            <td>{{ $booking->time }}</td>
            <td>{{ $booking->task }}</td>
            <td>{{ $booking->block_name }}</td>
            <td>{{ $booking->room }}</td>
            <td>{{ $booking->priority }}</td>
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
    <select name="task" id="task" required>
        <option value="" disabled selected>Select a task</option>
        @foreach ($complaints as $complaint)
            <option value="{{ $complaint->id }}"
                data-block="{{ $complaint->block_name }}"
                data-room="{{ $complaint->room }}"
                data-priority="{{ $complaint->priority_level }}">
                {{ $complaint->resource_type }} - {{ $complaint->description }}
            </option>
        @endforeach
    </select>

    <label for="block_name">Block Name:</label>
    <input type="text" name="block_name" id="block_name" readonly>

    <label for="room">Room:</label>
    <input type="text" name="room" id="room" readonly>

    <label for="priority">Priority:</label>
    <input type="text" name="priority" id="priority" readonly>

    <button type="submit">Book Maintenance</button>
</form>

<script>
    document.getElementById('task').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    console.log({
        block: selectedOption.getAttribute('data-block'),
        room: selectedOption.getAttribute('data-room'),
        priority: selectedOption.getAttribute('data-priority')
    });
    document.getElementById('block_name').value = selectedOption.getAttribute('data-block');
    document.getElementById('room').value = selectedOption.getAttribute('data-room');
    document.getElementById('priority').value = selectedOption.getAttribute('data-priority');
});

</script>



</body>
</html>
