<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-6VxQvlA9jDM2Y7t6d/6fMyZ5w5I2KMJf1mKq6mVqVt/YZsNRgh0rZU/NZDJQHwD3iJeqf9k3DBw//GJv4lh60A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
        .dashboard-container {
            max-width: 1200px;
            margin: auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .dashboard-header h1 {
            font-size: 24px;
            color: #333333;
            margin: 0;
        }
        .dashboard-header .dashboard-actions {
            display: flex;
            gap: 10px;
        }
        .dashboard-actions button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .dashboard-actions button:hover {
            background-color: #0056b3;
        }
        .dashboard-charts {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .chart-container {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .chart-icons {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
            z-index: 10;
        }
        .chart-icons i {
            color: #007bff;
            font-size: 20px;
            transition: color 0.3s ease;
            cursor: pointer;
        }
        .chart-icons i:hover {
            color: #0056b3;
        }
        .chart-icons i.active {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Admin Dashboard<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .export-button {
            margin-top: 20px;
        }
    </style></h1>
    
            <div class="dashboard-actions">
                <button onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                <button onclick="window.location.reload()"><i class="fas fa-sync"></i> Refresh</button>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

            </div>
        </div>

        <div class="dashboard-charts">
            <div class="chart-container">
                <div class="chart-icons">
                    <i class="fas fa-cog active"></i>
                    <i class="fas fa-info-circle"></i>
                </div>
                <h2>User Creations Per Day</h2>
                <canvas id="userCreationChart"></canvas>
            </div>

            <div class="chart-container">
                <div class="chart-icons">
                    <i class="fas fa-cog active"></i>
                    <i class="fas fa-info-circle"></i>
                </div>
                <h2>Product Distribution</h2>
                <canvas id="productPieChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx1 = document.getElementById('userCreationChart').getContext('2d');
            var ctx2 = document.getElementById('productPieChart').getContext('2d');

            var labels = @json($labels);
            var userCreations = @json($userCreations);
            var totalUsers = @json($totalUsers);
            var totalUsersData = @json($totalUsersData);
            var productLabels = @json($productLabels);
            var productCounts = @json($productCounts);

            var userCreationChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'User Creations',
                        data: userCreations,
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Total Users',
                        data: totalUsersData,
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'User Creations and Total Users',
                            font: {
                                size: 18
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                                font: {
                                    size: 14
                                }
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Users',
                                font: {
                                    size: 14
                                }
                            },
                            beginAtZero: true,
                            grid: {
                                color: '#f0f0f0',
                                borderWidth: 1,
                                borderColor: '#e0e0e0'
                            }
                        }
                    }
                }
            });

            var productPieChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: productLabels,
                    datasets: [{
                        label: 'Product Distribution',
                        data: productCounts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Product Distribution by Name',
                            font: {
                                size: 18
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
