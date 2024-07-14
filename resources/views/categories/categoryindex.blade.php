@extends('adminindex')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1c1e21;
            color: #fff;
            font-family: Arial, sans-serif;
            padding-top: 50px;
        }
        .container {
            margin-top: 20px;
        }
        .btn {
            margin-top: 20px;
        }
        .card {
            background-color: #2d2f33;
            border: none;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #36393f;
            border-bottom: 1px solid #444;
            padding: 10px 15px;
        }
        .card-body {
            padding: 15px;
        }
        .card-footer {
            background-color: #36393f;
            border-top: 1px solid #444;
            padding: 10px 15px;
            text-align: right;
        }
        .btn-warning, .btn-danger {
            color: #fff;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .float-right {
            float: right;
        }
        /* Additional style for shifting content */
        .container.shift {
            margin-left: 250px; /* Shift content right when panel is shown */
            transition: margin-left 0.3s ease; /* Smooth transition for content shift */
        }
    </style>
</head>
<body>
    <div class="container" id="categoryContainer">
        <h1 class="mb-4">Categories</h1>
        <button class="btn btn-primary mb-3" onclick="showCreateForm()">Add Category</button>
        <div id="categories"></div>
    </div>

    <!-- Create and Edit Form Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <input type="hidden" id="categoryId">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchCategories();

            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#categoryId').val();
                if (id) {
                    updateCategory(id);
                } else {
                    createCategory();
                }
            });
        });

        function fetchCategories() {
            $.ajax({
                url: '/api/categories',
                method: 'GET',
                success: function(response) {
                    let categories = '';
                    response.forEach(function(category) {
                        categories += 
                            `<div class="card">
                                <div class="card-header">
                                    ${category.name}
                                    <button class="btn btn-danger btn-sm float-right" onclick="deleteCategory(${category.id})">Delete</button>
                                    <button class="btn btn-warning btn-sm float-right mr-2" onclick="showEditForm(${category.id})">Edit</button>
                                </div>
                                <div class="card-body">
                                    ${category.description}
                                </div>
                                <div class="card-footer">
                                    Created: ${formatDate(category.created_at)}
                                </div>
                            </div>`;
                    });
                    $('#categories').html(categories);
                },
                error: function(xhr) {
                    alert('Error fetching categories: ' + xhr.responseText);
                }
            });
        }

        function showCreateForm() {
            $('#categoryForm')[0].reset();
            $('#categoryId').val('');
            $('#categoryModalLabel').text('Create Category');
            $('#categoryModal').modal('show');
        }

        function showEditForm(id) {
            $.ajax({
                url: `/api/categories/${id}`,
                method: 'GET',
                success: function(category) {
                    $('#name').val(category.name);
                    $('#description').val(category.description);
                    $('#categoryId').val(category.id);
                    $('#categoryModalLabel').text('Edit Category');
                    $('#categoryModal').modal('show');
                },
                error: function(xhr) {
                    alert('Error fetching category: ' + xhr.responseText);
                }
            });
        }

        function createCategory() {
            $.ajax({
                url: '/api/categories',
                method: 'POST',
                data: $('#categoryForm').serialize(),
                success: function() {
                    $('#categoryModal').modal('hide');
                    fetchCategories();
                },
                error: function(xhr) {
                    alert('Error creating category: ' + xhr.responseText);
                }
            });
        }

        function updateCategory(id) {
            $.ajax({
                url: `/api/categories/${id}`,
                method: 'PUT',
                data: $('#categoryForm').serialize(),
                success: function() {
                    $('#categoryModal').modal('hide');
                    fetchCategories();
                },
                error: function(xhr) {
                    alert('Error updating category: ' + xhr.responseText);
                }
            });
        }

        function deleteCategory(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: `/api/categories/${id}`,
                    method: 'DELETE',
                    success: function() {
                        fetchCategories();
                    },
                    error: function(xhr) {
                        alert('Error deleting category: ' + xhr.responseText);
                    }
                });
            }
        }

        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }
    </script>
</body>
</html>
