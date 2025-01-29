<!DOCTYPE html>
<html>
<head>
    <title>Technician UI - List of Complaints</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
    body {
        background-image: url('{{ asset('images/Background.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    .table-container {
        background-color: rgba(255, 255, 255, 0.8); /* Keep the semi-transparent background for content readability */
        border-radius: 10px;
        padding: 20px;
        margin: 20px auto;
        max-width: 90%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .filter-sort-buttons {
        display: flex;
        gap: 10px;
    }

    .icon {
        font-size: 24px;
    }
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        max-width: 100vw;
        box-sizing: border-box;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #004aad;
        padding: 10px 20px;
        color: white;
        z-index: 1000; /* Ensures it's above other content */
    }


    .navbar-menu {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .navbar-menu li {
        margin: 0 10px;
    }

    .navbar-menu a {
        text-decoration: none;
        color: white;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .navbar {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .navbar-menu {
            flex-direction: column;
            width: 100%;
        }

        .navbar-menu li {
            margin: 5px 0;
        }
    }
    /* Logout Button */
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
    <div class="table-container">
        <!-- Top Bar -->
        <div class="top-bar">
            <h2>List of Complaints</h2>
            <div class="filter-sort-buttons">
                <!-- Filter Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Filter by Priority
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?priority=high">High</a></li>
                        <li><a class="dropdown-item" href="?priority=medium">Medium</a></li>
                        <li><a class="dropdown-item" href="?priority=low">Low</a></li>
                        <li><a class="dropdown-item" href="/complaints">Clear Filter</a></li>
                    </ul>
                </div>

                <!-- Sort Buttons -->
                <a href="{{ route('complaints.index', ['sort' => 'desc']) }}" class="btn btn-primary">Sort:High to Low </a>
                <a href="{{ route('complaints.index', ['sort' => 'asc']) }}" class="btn btn-primary">Sort:Low to High </a>

            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Priority</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->created_at }}</td>
                    <td>{{ $complaint->block_name }}, {{ $complaint->room }}</td>
                    <td>{{ ucfirst($complaint->priority) }}</td>
                    <td>
                        <!-- Action Button to Open Modal -->
                        <button 
                            type="button" 
                            class="btn btn-info btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#complaintModal{{ $complaint->id }}">
                            View Details
                        </button>
                    </td>
                </tr>

                <!-- Modal -->
                <div 
                    class="modal fade" 
                    id="complaintModal{{ $complaint->id }}" 
                    tabindex="-1" 
                    aria-labelledby="complaintModalLabel{{ $complaint->id }}" 
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="complaintModalLabel{{ $complaint->id }}">Complaint Details</h5>
                                <button 
                                    type="button" 
                                    class="btn-close" 
                                    data-bs-dismiss="modal" 
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Block Name:</strong> {{ $complaint->block_name }}</p>
                                <p><strong>Room:</strong> {{ $complaint->room }}</p>
                                <p><strong>Date Created:</strong> {{ $complaint->created_at }}</p>
                                <p><strong>Description:</strong> {{ $complaint->description }}</p>
                                @if ($complaint->image)
                                <p><strong>Image:</strong></p>
                                <img src="{{ asset('storage/' . $complaint->image) }}" alt="Complaint Image" class="img-fluid">
                                @endif
                                <p><strong>Status:</strong> {{ ucfirst($complaint->status) }}</p>
                            </div>
                            <div class="modal-footer">
                                <!-- Resolved Button -->
                                <form method="POST" action="/complaints/{{ $complaint->id }}/resolve">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Resolved!</button>
                                </form>
                                <button 
                                    type="button" 
                                    class="btn btn-secondary" 
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No complaints yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Resolved Complaints Modal -->
    <div class="modal fade" id="resolvedComplaintsModal" tabindex="-1" aria-labelledby="resolvedComplaintsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resolvedComplaintsLabel">Resolved Complaints</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-wrapper">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Block</th>
                                <th>Room</th>
                                <th>Priority</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="resolvedComplaintsContent">
                            <!-- Content will be dynamically loaded -->
                        </tbody>
                    </table>
                </div>
                <p id="noComplaintsMessage" class="text-center">No resolved complaints found.</p>
            </div>
        </div>
    </div>
</div>



<script>
    // Attach event listener to the modal itself
    const resolvedModal = document.getElementById('resolvedComplaintsModal');

    resolvedModal.addEventListener('show.bs.modal', function () {
        // Fetch resolved complaints
        fetch('/complaints/resolved')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const contentDiv = document.getElementById('resolvedComplaintsContent');
                const noComplaintsMessage = document.getElementById('noComplaintsMessage');

                if (data.length > 0) {
                    let html = '';
                    data.forEach(complaint => {
                        const date = new Date(complaint.created_at).toLocaleString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true,
                        });

                        html += `
                            <tr>
                                <td>${date}</td>
                                <td>${complaint.block_name || 'N/A'}</td>
                                <td>${complaint.room || 'N/A'}</td>
                                <td>${complaint.priority || 'N/A'}</td>
                                <td>${complaint.description || 'N/A'}</td>
                                <td>${complaint.status || 'N/A'}</td>
                            </tr>
                        `;
                    });

                    contentDiv.innerHTML = html;
                    noComplaintsMessage.style.display = 'none'; // Hide "no complaints" message
                } else {
                    contentDiv.innerHTML = ''; // Clear table
                    noComplaintsMessage.style.display = 'block'; // Show "no complaints" message
                }
            })
            .catch(error => {
                console.error('Error fetching resolved complaints:', error);
                document.getElementById('resolvedComplaintsContent').innerHTML =
                    '<tr><td colspan="6" class="text-center">Error loading resolved complaints.</td></tr>';
            });
    });
</script>

    <!-- Bootstrap JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
