<!DOCTYPE html>
<html>
<head>
    <title>Complaint History</title>
</head>
<body>
    <h1>Complaint History</h1>

    <h2>Complaint ID: {{ $complaint->id }}</h2>

    <table border="1">
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
                    <td>{{ $history->status }}</td>
                    <td>{{ $history->remarks }}</td>
                    <td>{{ $history->changed_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
