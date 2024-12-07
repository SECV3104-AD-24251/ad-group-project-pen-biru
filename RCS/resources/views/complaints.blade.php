<!DOCTYPE html>
<html>
<head>
    <title>Technician UI - List of Complaints</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        .table-container {
            margin: 20px auto;
            max-width: 90%;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .filter-sort-buttons {
            display: flex;
            gap: 10px;
        }
        .bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f8f9fa;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        }
        .bottom-bar a {
            text-decoration: none;
            color: #000;
            text-align: center;
        }
        .bottom-bar a:hover {
            color: #007bff;
        }
        .icon {
            font-size: 24px;
        }
    </style>
</head>
<body>
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
                        <li><a class="dropdown-item" href="?priority=normal">Normal</a></li>
                        <li><a class="dropdown-item" href="?priority=low">Low</a></li>
                        <li><a class="dropdown-item" href="/complaints">Clear Filter</a></li>
                    </ul>
                </div>

                <!-- Sort Buttons -->
                <a href="?sort=asc" class="btn btn-primary">Sort: High to Low</a>
                <a href="?sort=desc" class="btn btn-primary">Sort: Low to High</a>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Priority</th>
                    <th>Status</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->created_at }}</td>
                    <td>{{ $complaint->block_name }} , {{ $complaint->room }}</td>
                    <td>{{ ucfirst($complaint->priority) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No complaints yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Bottom Bar -->
    <div class="bottom-bar">
        <a href="#" class="list-view">
            <div class="icon">📋</div>
            <span>List</span>
        </a>
        <a href="#" class="resolved-view">
            <div class="icon">✅</div>
            <span>Resolved</span>
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
