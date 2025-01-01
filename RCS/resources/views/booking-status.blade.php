<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Bookings</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">List of Maintenance Bookings</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Task</th>
                    <th>Block Name</th>
                    <th>Room</th>
                    <th>Priority</th>
                    <th>Suitability</th> <!-- New column -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingBookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->date }}</td>
                        <td>{{ $booking->time }}</td>
                        <td>{{ $booking->task }}</td>
                        <td>{{ $booking->block_name }}</td>
                        <td>{{ $booking->room }}</td>
                        <td>{{ $booking->priority }}</td>
                        <!-- Conflict Checker -->
                        <td>
                            <span class="badge {{ $booking->is_suitable ? 'bg-success' : 'bg-danger' }}">
                                {{ $booking->is_suitable ? 'Suitable' : 'Not Suitable' }}
                            </span>
                        </td> <!-- New data -->
                        <td>
                            <a href="{{ route('maintenance-bookings.approve', $booking->id) }}" class="btn btn-success">Approve</a>
                            <a href="{{ route('maintenance-bookings.disapprove', $booking->id) }}" class="btn btn-danger">Disapprove</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="mt-5 mb-4">Booking History</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Task</th>
                    <th>Block Name</th>
                    <th>Room</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->date }}</td>
                        <td>{{ $booking->time }}</td>
                        <td>{{ $booking->task }}</td>
                        <td>{{ $booking->block_name }}</td>
                        <td>{{ $booking->room }}</td>
                        <td>{{ $booking->priority }}</td>
                        <td>{{ ucfirst($booking->booking_status) }}</td>
                        <td>
                            <form action="{{ route('maintenance-bookings.updateStatus', $booking->id) }}" method="POST">
                                @csrf
                                <select name="booking_status" class="form-select">
                                    <option value="approved" {{ $booking->booking_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="disapproved" {{ $booking->booking_status == 'disapproved' ? 'selected' : '' }}>Disapproved</option>
                                </select>
                                <button type="submit" class="btn btn-primary mt-1">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
