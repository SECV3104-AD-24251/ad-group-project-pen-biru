<!DOCTYPE html>
<html>
<head>
    <title>Analytics Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin: 20px auto;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-top: 20px;
            text-align: center;
            color: #343a40;
        }
        #chartContainer {
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            <canvas id="complaintsChart" width="300" height="300"></canvas>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample data (replace this with data from your backend)
        const resolvedComplaints = 75;
        const unresolvedComplaints = 25;
        const totalComplaints = resolvedComplaints + unresolvedComplaints;

        // Update card data dynamically
        document.getElementById('totalComplaints').textContent = totalComplaints;
        document.getElementById('resolvedComplaints').textContent = resolvedComplaints;
        document.getElementById('unresolvedComplaints').textContent = unresolvedComplaints;

        // Chart configuration
        const ctx = document.getElementById('complaintsChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut', // Doughnut chart
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
    </script>
</body>
</html>
