<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints List</title>
    <!-- Add Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Set table background with 50% opacity */
        .table-opacity {
            background-color: rgba(255, 255, 255, 0.1); /* White with 50% opacity */
        }

        /* Optional: Style table headers for contrast */
        .table thead th {
            background-color: rgba(0, 0, 0, 0.3); /* Black with 30% opacity */
            color: white; /* Text color */
        }

        h1 {
            color: white;
        }
    </style>


</head>
<body style="background: url('/images/51696.jpg') no-repeat center center fixed; background-size: cover;">
    <div class="container mt-5">
        <h1 class="mb-4">Complaints List</h1>

        <!-- Display success messages -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped table-opacity" >
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
                        <!-- <td>
                            //Display Suggested Priority based on Severity
                            <span class="text-info">
                                Suggested Priority: {{ $complaint->suggestedPriority }}
                            </span>
                        </td> -->
                        <!-- Display Suggested Priority based on Severity -->
                        <td>
                            @if (isset($complaint->suggested_priority))
                                Suggested Priority: {{ $complaint->suggested_priority }}
                            @else
                                Suggested Priority: Not Available
                            @endif
                        </td>
                     
                        <td>
                            <!-- Form to assign priority -->
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

       <!-- Booking approval -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('maintenance-bookings.status') }}" class="btn btn-primary">View Booking Status</a>
    </div>

    <div class="d-flex justify-content-end mb-4">
    <a href="{{ route('maintenance-bookings.status') }}" class="btn btn-primary">View Booking Status</a>
    </div>

    <!-- Add Bootstrap JS for interactivity (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
