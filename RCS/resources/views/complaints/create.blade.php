<!DOCTYPE html>
<html>
<head>
    <title>Submit Complaint</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .container {
            margin: 20px auto;
            max-width: 80%;
        }
        .table-container {
        background-color: rgba(255, 255, 255, 0.8); /* Adds a semi-transparent white background for readability */
        border-radius: 10px; /* Rounds the corners */
        padding: 20px;
        margin: 20px auto;
        max-width: 90%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Adds a subtle shadow for better visibility */
    }
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
            color: Black; font-size: 36px !important;
        }
    </style>
    <!-- Include Vite CSS and JS -->
</head>
<body style ="background: url('/images/createbg.jpg') no-repeat center center fixed; background-size: cover;">
    <div class="table-container">
    <div class="container">
        <h1 class="text-center mb-4">Submit a Complaint</h1>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Complaint Form -->
        <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="mb-3">
            <label for="block_name" class="form-label">Block Name:</label>
            <select name="block_name" id="block_name" class="form-select" required>
        <option value="">Select a block</option>
        @foreach ($blocks as $block)
            <option value="{{ $block }}">{{ $block }}</option>
        @endforeach
        </select>
        </div>

        <div class="mb-3">
        <label for="room" class="form-label">Room:</label>
        <select name="room" id="room" class="form-select" required>
        <option value="">Select a room</option>
        </select>
        </div>

            <!-- Resource Type Dropdown -->
            <div class="mb-3">
    <label for="resource_type" class="form-label">Resource Type:</label>
    <select name="resource_type" id="resource_type" class="form-select" required>
        <option value="">Select a resource</option>
        @foreach($resources as $resource)
            <option value="{{ $resource }}">{{ $resource }}</option>
        @endforeach
    </select>
</div>

    <div class="mb-3">
        <label for="details" class="form-label">Details:</label>
        <select name="details" id="details" class="form-select" required>
            <option value="">Select Details</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="severity" class="form-label">Severity:</label>
        <input type="text" name="severity" id="severity" class="form-control" readonly>
    </div>
    <div class="mb-3"> <label for="description" class="form-label">Description:</label> 
    <textarea name="description" id="description" class="form-control" required></textarea> 
    </div>

            <div class="mb-3">
                <label for="image" class="form-label">Upload an Image:</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- List of Complaints -->
        <div class="table-container">
            <h2>Submitted Complaints</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Block Name</th>
                        <th>Room</th>
                        <th>Resource Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint->block_name }}</td>
                        <td>{{ $complaint->room }}</td>
                        <td>{{ $complaint->resource_type }}</td>
                        <td>{{ ucfirst($complaint->status) }}</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#historyModal" data-id="{{ $complaint->id }}">Detail</a>
                            <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this complaint?')">Delete</button>
                            </form>
                        </td>                       
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Complaint History Modal -->
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyModalLabel">Complaint History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="history-container">
                    <!-- Content will be dynamically loaded here -->
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Dynamic Details Dropdown -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</body>
<script>
    document.getElementById('block_name').addEventListener('change', function () {
        const block = this.value;
        const roomDropdown = document.getElementById('room');

        // Clear existing options
        roomDropdown.innerHTML = '<option value="">Select a room</option>';

        if (block) {
            fetch("{{ route('fetch.rooms') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ block: block })
            })
            .then(response => response.json())
            .then(rooms => {
                rooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room;
                    option.textContent = room;
                    roomDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching rooms:', error));
        }
    });
</script>

</html>
