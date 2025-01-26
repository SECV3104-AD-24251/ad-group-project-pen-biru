<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar student">
        <div class="navbar-brand">Resource Complaint System</div>
        <ul class="navbar-menu">
            <li><a href="/student-dashboard">Home</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Courses</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="{{ route('logout') }}" class="logout-btn">Logout</a></li>
        </ul>
    </nav>
    <main class="dashboard-content">
    <h1>Welcome {{ session('user')->name ?? 'Guest' }}</h1>

        <div class="floating-box">
            <h2>What would you like to do?</h2>
            <div class="button-container">
                <a href="{{ route('complaints.create') }}" class="btn">Make Complaint</a>
                <a href="{{ route('student.resources') }}" class="btn">View Classroom</a>
            </div>
        </div>

    </main>
</body>
</html>
