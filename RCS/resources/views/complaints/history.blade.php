<!DOCTYPE html>
<html>
<head>
    <title>Complaint History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
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
        <h1 class="text-center mb-4">Complaint History</h1>

        <h2 class="mb-4">Complaint ID: <span class="text-primary">{{ $complaint->id }}</span></h2>

        <!-- History Table -->
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Changed At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($complaint->histories as $history)
                    <tr>
                        <td>{{ ucfirst($history->status) }}</td>
                        <td>{{ $history->remarks }}</td>
                        <td>{{ $history->changed_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
