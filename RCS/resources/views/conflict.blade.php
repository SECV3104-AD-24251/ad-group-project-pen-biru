<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conflict Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background-image: url('{{ asset('images/Background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        /* Container Styles */
        .container {
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); /* Subtle shadow for better contrast */
        }
        /* Table Styles */
        .table {
            color: white; 
        }
    </style>
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
    <div class="container mt-5">
        <h1 style="color: white;">Conflict Management</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Button to Add a New Conflict -->
        <a href="{{ route('conflict.create') }}" class="btn btn-primary mb-3">Report Conflict</a>

        <!-- Conflicts Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Room</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($conflicts as $conflict)
                    <tr>
                        <td>{{ $conflict->date }}</td>
                        <td>{{ $conflict->time }}</td>
                        <td>{{ $conflict->room }}</td>
                        <td>{{ $conflict->description }}</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
