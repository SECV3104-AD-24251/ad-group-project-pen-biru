<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Body background image */
        body {
            background-image: url('/images/Timetablebg.jpg'); 
            background-size: cover;
            background-position: center;
            color: #fff; /* Text color to contrast against the background */
            font-family: 'Montserrat', sans-serif;
        }

        /* Container Styling */
        .container {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Table Styling */
        table {
            background-color: rgba(255, 255, 255, 0.6); /* 60% transparency */
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            margin-top: 30px;
            transition: opacity 0.5s ease-in-out;
        }

        table th, table td {
            padding: 15px;
            text-align: center;
            vertical-align: middle;
        }

        /* Header Row Styling */
        table thead {
            background-color:rgba(62, 151, 247, 0.66); /* Blue background for header */
            color: white;
        }

        /* Row Styling */
        table tbody tr {
            background-color: rgba(255, 255, 255, 0.9);
            transition: background-color 0.3s ease-in-out;
        }

        table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1); /* Hover effect */
        }

        /* Filter Dropdown Styling */
        .form-select {
            border-radius: 25px;
            padding: 8px 15px;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ddd;
        }

        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Timetable</h1>

        <!-- Filter Form for Block -->
        <form method="GET" action="{{ route('timetable.show') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="block" class="form-select">
                        <option value="">Clear Filter</option>
                        <option value="A" {{ request()->block == 'A' ? 'selected' : '' }}>Block A</option>
                        <option value="B" {{ request()->block == 'B' ? 'selected' : '' }}>Block B</option>
                        <option value="C" {{ request()->block == 'C' ? 'selected' : '' }}>Block C</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <!-- Timetable Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Block</th>
                    <th>Room</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Subject</th>
                    <th>Instructor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timetable as $slot)
                    <tr>
                        <td>{{ $slot->block }}</td>
                        <td>{{ $slot->room_name }}</td>
                        <td>{{ $slot->day }}</td>
                        <td>{{ $slot->start_time }}</td>
                        <td>{{ $slot->end_time }}</td>
                        <td>{{ $slot->subject }}</td>
                        <td>{{ $slot->instructor }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
