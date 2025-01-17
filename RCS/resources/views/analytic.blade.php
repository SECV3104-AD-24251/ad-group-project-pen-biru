<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('/images/createbg.jpg'); /* Replace with your image path */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent repeating */
            font-family: Arial, sans-serif;
        }
        
        .container {
        margin-top: 50px;
        padding: 20px; /* Add padding to the container */
        }

        .card {
        margin: 20px auto;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Increased shadow for depth */
        border-radius: 10px; /* Rounded corners */
        transition: transform 0.2s; /* Smooth transition */
        }

        .card:hover {
            transform: translateY(-5px); /* Lift effect on hover */
        }
        h1 {
            margin-top: 20px;
            text-align: center;
            color: #343a40;
        }
        #chartContainer,
#feedbackChartContainer,
.card.bg-light.text-dark {
    margin: 40px auto; /* Center horizontally */
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    max-width: 600px; /* Uniform width for all containers */
    width: 100%; /* Responsive layout */
}

#complaintsChart,
#feedbackChart {
    max-width: 500px; /* Ensure the charts are consistent in size */
    max-height: 500px;
    width: 100%; /* Responsive layout */
    height: auto; /* Maintain aspect ratio */
}

.card.bg-light.text-dark {
    text-align: center;
    max-width: 600px; /* Same width as the charts */
}

    </style>
</head>
<body>
<div class="container">
    <h1>Analytics Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h3>Total Complaints</h3>
                    <p class="display-4" id="totalComplaints">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h3>Resolved Complaints</h3>
                    <p class="display-4" id="resolvedComplaints">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h3>Unresolved Complaints</h3>
                    <p class="display-4" id="unresolvedComplaints">0</p>
                </div>
            </div>
        </div>
    </div>

    <div id="chartContainer">
        <h3 class="text-center">Complaints Overview</h3>
        <canvas id="complaintsChart" width="200" height="200"></canvas>
    </div>

    

    <div id="feedbackChartContainer">
        <h3 class="text-center">Feedback Overview</h3>
        <canvas id="feedbackChart" width="200" height="200"></canvas>
    </div>
</div>

<!-- <div class="card bg-light text-dark">
        <div class="card-body">
            <h3>User Suggestion</h3>
            <p id="randomSuggestion" class="lead">Fetching suggestion...</p>
        </div>
    </div> -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    fetch('/complaints/statistics')
    .then(response => response.json())
    .then(data => {
        const resolvedComplaints = data.resolved;
        const unresolvedComplaints = data.unresolved;
        const totalComplaints = resolvedComplaints + unresolvedComplaints;

        // Update card data dynamically
        document.getElementById('totalComplaints').textContent = totalComplaints;
        document.getElementById('resolvedComplaints').textContent = resolvedComplaints;
        document.getElementById('unresolvedComplaints').textContent = unresolvedComplaints;

        // Update chart
        const ctx = document.getElementById('complaintsChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Resolved Complaints', 'Unresolved Complaints'],
                datasets: [{
                    data: [resolvedComplaints, unresolvedComplaints],
                    backgroundColor: ['#28a745', '#dc3545'],
                    hoverBackgroundColor: ['#218838', '#c82333'],
                    borderColor: '#fff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 1, // Set aspect ratio to 1 for a perfect circle
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const value = context.raw;
                                const percentage = ((value / totalComplaints) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching complaint statistics:', error));

    //feedback chart scripts
    fetch('/feedback/statistics')
    .then(response => response.json())
    .then(data => {
        // Feedback Metrics
        const feedbackMetrics = data.metrics;
        const labels = Object.keys(feedbackMetrics);
        const values = Object.values(feedbackMetrics);

        // Feedback Chart
        const feedbackCtx = document.getElementById('feedbackChart').getContext('2d');
        new Chart(feedbackCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average Feedback Rating',
                    data: values,
                    backgroundColor: '#007bff',
                    borderColor: '#0056b3',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true, // Ensure it resizes
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Rating (1-5)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                }
            }
        });

        // Random Suggestion
        const randomSuggestion = data.random_suggestion || 'No suggestions available.';
        document.getElementById('randomSuggestion').textContent = randomSuggestion;
    })
    .catch(error => console.error('Error fetching feedback statistics:', error));
    </script>
</body>
</html>
