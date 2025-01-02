<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('/images/maintenance_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        h1 {
            font-size: 48px;
        }

        h2 {
            font-size: 28px;
        }

        .container {
            max-width: 90%;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .table-container {
            max-height: 400px; /* Adjust the height as needed */
            overflow-y: auto; /* Enable vertical scrolling */
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
        }

        table thead th {
            background-color: #4CAF50;
            color: #fff;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        table tbody tr:nth-child(even) {
            background-color: #fff;
        }

        form {
            margin-top: 30px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="date"],
        input[type="time"],
        select,
        input[type="text"],
        button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
    <title>Maintenance Bookings</title>
</head>
<body>
    <h1>Maintenance Bookings</h1>
    <div class="container">
        <!-- Display existing bookings -->
        <div class="table-container">
        <h2>List of Bookings</h2>
<table border="1">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Task (Resource Type)</th>
            <th>Block Name</th>
            <th>Room</th>
            <th>Priority Level</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bookings as $booking)
            <tr>
                <td>{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->time)->format('H:i') }}</td>
                <td>{{ $booking->task }}</td>
                <td>{{ $booking->block_name }}</td>
                <td>{{ $booking->room }}</td>
                <td>{{ $booking->priority }}</td>
                <td>{{ ucfirst($booking->booking_status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

        </div>

        <form action="{{ url('maintenance-bookings') }}" method="POST">
    @csrf
    <label for="date">Date:</label>
    <input type="date" name="date" required>

    <label for="time">Time:</label>
    <input type="time" name="time" required>

    <label for="task">Task (Resource Type):</label>
    <select name="task" id="task" required>
        <option value="" disabled selected>Select a task</option>
        @foreach ($complaints as $complaint)
            <option value="{{ $complaint->resource_type }}"
                data-block="{{ $complaint->block_name }}"
                data-room="{{ $complaint->room }}"
                data-priority="{{ $complaint->priority }}">
                {{ $complaint->resource_type }} - {{ $complaint->block_name }},  {{ $complaint->room }}, {{ $complaint->priority }}
            </option>
        @endforeach
    </select>

    <label for="block_name">Block Name:</label>
    <input type="text" name="block_name" id="block_name" readonly>

    <label for="room">Room:</label>
    <input type="text" name="room" id="room" readonly>

    <label for="priority">Priority Level:</label>
    <input type="text" name="priority" id="priority" readonly>

    <button type="submit">Book Maintenance</button>
</form>

<script>
    // Auto-fill fields based on the selected task
    document.getElementById('task').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('block_name').value = selectedOption.getAttribute('data-block');
        document.getElementById('room').value = selectedOption.getAttribute('data-room');
        document.getElementById('priority').value = selectedOption.getAttribute('data-priority');
    });
</script>


</body>
</html>
