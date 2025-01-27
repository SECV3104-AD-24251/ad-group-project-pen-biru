<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;

            background-image: url('{{ asset('images/Background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        h1, h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
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
            max-height: 400px;
            overflow-y: auto;
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

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
    <title>Maintenance Bookings</title>
</head>
<body>
    <nav class="navbar technician">
        <div class="navbar-brand">Resource Complaint System</div>
        <ul class="navbar-menu">
            <li><a href="/complaints">Home</a></li>
            <li><a href="{{ route('analytics.index') }}">Analytic</a></li>
            <li><a href="{{ route('conflict.index') }}">Report Conflict</a></li>
            <li><a href="{{ route('timetable.show') }}">View Timetable</a></li>
            <li><a href="{{ route('maintenance.bookings') }}">Book Maintenance</a></li>
            <li><a href="{{ route('logout') }}" class="logout-btn">Logout</a></li>
        </ul>
    </nav>
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

        <!-- Complaints Table -->
        <div class="table-container">
            <h2>Pending Complaints</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Resource Type</th>
                        <th>Block Name</th>
                        <th>Room</th>
                        <th>Priority</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($complaints as $complaint)
                        <tr>
                            <form action="{{ url('maintenance-bookings') }}" method="POST">
                                @csrf
                                <td>{{ $complaint->id }}</td>
                                <td>{{ $complaint->resource_type }}</td>
                                <td>{{ $complaint->block_name }}</td>
                                <td>{{ $complaint->room }}</td>
                                <td>{{ $complaint->priority }}</td>
                                <td>
                                    <input type="date" name="date" required>
                                </td>
                                <td>
                                    <input type="time" name="time" required>
                                </td>
                                <td>
                                    <input type="hidden" name="task" value="{{ $complaint->resource_type }}">
                                    <input type="hidden" name="block_name" value="{{ $complaint->block_name }}">
                                    <input type="hidden" name="room" value="{{ $complaint->room }}">
                                    <input type="hidden" name="priority" value="{{ $complaint->priority }}">
                                    <button type="submit">Book</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
