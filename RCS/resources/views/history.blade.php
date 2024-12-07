<!DOCTYPE html>
<html>
<head>
    <title>Status History</title>
</head>
<body>
    <h1>Status History for Complaint #{{ $complaint->id }}</h1>

    <ul>
        @foreach($statuses as $status)
            <li>{{ $status->status }} - {{ $status->created_at }}</li>
        @endforeach
    </ul>

</body>
</html>
