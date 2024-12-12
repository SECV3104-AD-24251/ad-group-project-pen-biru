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
            margin-top: 30px;
        }
    </style>
</head>
<body>
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
                    @foreach($blocks as $block)
                        <option value="{{ $block }}">{{ $block }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="room" class="form-label">Room:</label>
                <input type="text" name="room" id="room" class="form-control" required>
            </div>

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
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" id="description" class="form-control"></textarea>
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

    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyModalLabel">Complaint History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- History content will be loaded here dynamically -->
                    <div id="modalHistoryContent">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('historyModal');
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const complaintId = button.getAttribute('data-id'); // Extract info from data-* attributes
                
                // Use AJAX to fetch the history content
                fetch(`/complaints/${complaintId}/history`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modalHistoryContent').innerHTML = html;
                    })
                    .catch(error => {
                        document.getElementById('modalHistoryContent').innerHTML = 'Error loading history.';
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</body>
</html>
