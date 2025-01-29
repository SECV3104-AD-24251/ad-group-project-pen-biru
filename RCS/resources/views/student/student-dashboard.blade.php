<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background-image: url('{{ asset('images/Background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Container Styles */
        .container {
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); /* Subtle shadow for better contrast */
            margin-top: 20px;
        }

        h1 {
            color: white;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5); /* Subtle shadow for contrast */
        }

        .route-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #004aad;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .navbar {
    max-width: 1459px; /* Adjust as needed /
    margin: 0 auto; / Centers the navbar */
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #004aad;
    color: white;
    border-radius: 8px;
}

    </style>
</head>
<body>
    <nav class="navbar student">
        <div class="navbar-brand">Resource Complaint System</div>
        <ul class="navbar-menu">
            <li><a href="/student-dashboard">Home</a></li>
            <li><a href="{{ route('logout') }}" class="logout-btn">Logout</a></li>
        </ul>
    </nav>
    <main class="dashboard-content">
        <div class="container">
            <h1>Welcome {{ session('user')->name ?? 'Guest' }}</h1>

            <div class="floating-box">
                <h2>What would you like to do?</h2>
                <div class="button-container">
                    <a href="{{ route('complaints.create') }}" class="btn">Make Complaint</a>
                    <a href="{{ route('student.resources') }}" class="btn">View Classroom</a>
                </div>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <a href="/feedback" class="route-button">Give us a Feedback</a>
            </div>
        </div>
    </main>
</body>
</html>
