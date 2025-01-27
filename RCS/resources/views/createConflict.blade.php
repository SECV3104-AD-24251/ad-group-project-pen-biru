<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Conflict</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">\
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
        /* Set label font color to white */
        label {
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
        <h1 class="text-center mb-4" style="color: white;">Report a Conflict</h1>

        <!-- Conflict Form -->
        <form action="{{ route('conflict.store') }}" method="POST" class="p-4 border rounded">
            @csrf
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <div class="mb-3">
                <label for="room" class="form-label">Room</label>
                <input type="text" class="form-control" id="room" name="room" placeholder="Enter room number or name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the issue..." required></textarea>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success">Submit Conflict</button>
            </div>
        </form>
    </div>
</body>
</html>
