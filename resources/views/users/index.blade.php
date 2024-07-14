
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        /* Dark mode styles */
        body {
            background-color: #262626; /* Dark gray background */
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .user-profile {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #333; /* Darker border color */
        }
        .user-profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid #fff; /* White border for contrast */
        }
        .user-details {
            flex: 1;
            font-size: 0.9rem;
        }
        .user-actions {
            margin-left: auto;
        }
        .editUser, .deleteUser {
            margin-left: 10px;
            text-decoration: none;
            padding: 5px 10px;
            background-color: #0095f6; /* Instagram blue */
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .editUser:hover, .deleteUser:hover {
            background-color: #007bb5; /* Darker blue on hover */
        }
        .createUserBtn {
            background-color: #0095f6; /* Instagram blue */
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .createUserBtn:hover {
            background-color: #007bb5; /* Darker blue on hover */
        }

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000; /* Ensure it appears above other content */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4); /* Semi-transparent background */
        }
        .modal-content {
            background-color: #262626; /* Dark background */
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Adjust width as needed */
            max-width: 600px; /* Maximum width of the modal */
            border-radius: 5px;
            position: relative;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User List</h1>

        <div id="userList">
            <!-- User profiles will be loaded here via AJAX -->
            @include('users.users_list')
        </div>

        <!-- Button to trigger create modal -->
        <button class="createUserBtn" id="createUserModalBtn">Create User</button>

        <!-- Create Modal container -->
        <div id="createUserModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="createUserForm">
                    <!-- Form content will be loaded here via AJAX -->
                </div>
            </div>
        </div>

        <!-- Edit Modal container -->
        <div id="editUserModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="editUserForm">
                    <!-- Form content will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and additional scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to open create modal and load create form
            $('#createUserModalBtn').click(function() {
                $('#createUserModal').css('display', 'block');
                $.get("{{ route('users.create') }}", function(data) {
                    $('#createUserForm').html(data);
                });
            });

            // Function to open edit modal and load edit form
            $(document).on('click', '.editUser', function(event) {
                event.preventDefault(); // Prevent default anchor tag behavior
                var userId = $(this).data('id');
                $('#editUserModal').css('display', 'block');
                $.get('/users/' + userId + '/edit', function(data) {
                    $('#editUserForm').html(data);
                });
            });

            // Close modal when clicking close button
            $(document).on('click', '.close', function() {
                $(this).closest('.modal').css('display', 'none');
            });

            // Close modal on escape key press
            $(document).keyup(function(e) {
                if (e.key === "Escape") {
                    $('.modal').css('display', 'none');
                }
            });
        });
    </script>
</body>
</html>

