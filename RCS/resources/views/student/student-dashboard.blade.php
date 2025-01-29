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
    max-width: 100vw; /* Ensures it doesn't go beyond the viewport width */
    width: 100%;
    box-sizing: border-box;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #004aad;
    padding: 10px 20px;
    color: white;
    overflow-x: hidden; /* Prevents horizontal scrolling */
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
