<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints List</title>
    <!-- Add Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* General Reset */
        body, h1, ul, li, a {
            margin: 0;
            padding: 0;
            text-decoration: none;
            list-style: none;
            font-family: Arial, sans-serif;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #4CAF50;
            padding: 1rem 2rem;
            color: white;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar-menu {
            display: flex;
            gap: 1rem;
        }

        .navbar-menu li {
            display: inline;
        }

        .navbar-menu a {
            color: white;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .navbar-menu a:hover {
            color: #d4edda;
        }

        .logout-btn {
            background-color: #f44336;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }

        /* Page Background */
        body {
            background: url('{{ asset('images/Background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            margin: 100;
            padding: 100;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Container Styles */
        .container {
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); /* Subtle shadow for better contrast */
        }

        /* Table Styles */
        .table-opacity {
            background-color: rgba(255, 255, 255, 0.8); /* White with 80% opacity */
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            background-color: rgba(0, 0, 0, 0.7); /* Black with 70% opacity */
            color: white; /* White text for readability */
        }

        /* Heading Text Styling */
        h1 {
            color: white;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5); /* Subtle shadow for contrast */
        }

        /* Button Styles */
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar staff">
        <div class="navbar-brand">Staff Dashboard</div>
        <ul class="navbar-menu">
            <li><a href="/staff-dashboard">Home</a></li>
            <li><a href="{{ route('maintenance-bookings.status') }}">View Booking Status</a></li>
            <li><a href="/condition">Resources</a></li>
            <li><a href="{{ route('logout') }}" class="logout-btn">Logout</a></li>
        </ul>
    </div>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Complaints List</h1>

        <!-- Display success messages -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped table-opacity">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Block Name</th>
                    <th>Room</th>
                    <th>Resource Type</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Priority Level</th>
                    <th></th>
                    <th>Assign Priority</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint->block_name }}</td>
                        <td>{{ $complaint->room }}</td>
                        <td>{{ $complaint->resource_type }}</td>
                        <td>{{ $complaint->description }}</td>
                        <td>
                            @if ($complaint->image)
                                <a href="{{ asset('storage/' . $complaint->image) }}" target="_blank">View Image</a>
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $complaint->priority ?? 'Not Assigned' }}</td>
                        <td>
                            @if (isset($complaint->suggested_priority))
                                Suggested Priority: {{ $complaint->suggested_priority }}
                            @else
                                Suggested Priority: Not Available
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('complaints.assignPriority', $complaint->id) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <select name="priority" class="form-select" required>
                                        <option value="" disabled selected>Select Priority</option>
                                        @foreach ($priorityLevels as $level)
                                            <option value="{{ $level }}" {{ $complaint->priority == $level ? 'selected' : '' }}>
                                                {{ $level }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Assign</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No complaints found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
