


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gadget Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* CSS for side panel and toggle button */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .side-panel {
            background-color: #343a40; /* Dark panel background */
            color: #fff; /* Light text color */
            position: fixed;
            top: 0;
            left: -250px; /* Initially hide the side panel */
            bottom: 0;
            width: 250px;
            padding: 60px 20px 20px; /* Add padding-top for toggle switch */
            overflow-y: auto;
            transition: left 0.3s ease; /* Smooth transition for sliding effect */
            z-index: 1000; /* Ensure it's above other content */
            text-align: center; /* Center text inside the panel */
        }
        .side-panel.show {
            left: 0; /* Show the side panel */
        }
        .side-panel-logo {
            margin-bottom: 20px;
        }
        .side-panel-logo img {
            max-width: 100%;
            height: auto;
        }
        .side-panel-nav {
            margin-top: 20px;
        }
        .side-panel-nav .nav-link {
            color: #fff;
            padding: 10px 20px;
            display: block;
        }
        .side-panel-nav .nav-link:hover {
            background-color: #495057; /* Darker shade on hover */
            text-decoration: none;
        }
        .toggle-switch {
            position: fixed;
            top: 20px;
            left: 20px; /* Positioned at the top-left of the viewport */
            width: 40px;
            height: 20px;
            background-color: #ccc;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Smooth transition for background color */
            z-index: 1001; /* Ensure it's above other content */
        }
        .toggle-switch::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            background-color: #fff;
            border-radius: 50%;
            transition: left 0.3s ease;
        }
        .toggle-switch.active {
            background-color: #007bff;
        }
        .toggle-switch.active::after {
            left: 22px;
        }
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease; /* Smooth transition for content shift */
            padding: 20px;
            text-align: center; /* Center text in main content */
        }
        .main-content.shift {
            margin-left: 250px; /* Shift content right when panel is shown */
        }
    </style>
</head>
<body>
    <!-- Toggle Button for Side Panel -->
    <div id="toggleSwitch" class="toggle-switch"></div>

    <!-- Side Panel -->
    <div class="side-panel show" id="sidePanel"> <!-- Add 'show' class to make it visible by default -->
        <div class="side-panel-logo">
            <img src="path/to/your/logo.png" alt="Logo">
        </div>
        <div class="side-panel-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a id="usersLink" class="nav-link" href="#users">User Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/products">Product Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/category">Category Management</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content') <!-- This will display the content from products.blade.php -->
    </div>

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle side panel
            $('#toggleSwitch').click(function() {
                $('#sidePanel').toggleClass('show');
                $(this).toggleClass('active');
                $('.main-content').toggleClass('shift');
            });

            // Ensure side panel is initially shown
            $('#toggleSwitch').addClass('active');
            $('#sidePanel').addClass('show');
            $('.main-content').addClass('shift');

            // Redirect to users index page when clicking on Users link (example)
            $('#usersLink').click(function(event) {
                event.preventDefault();
                window.location.href = "{{ route('users.index') }}";
            });
        });
    </script>
    
</body>
</html>
