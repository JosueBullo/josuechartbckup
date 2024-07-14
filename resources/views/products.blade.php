@extends('adminindex')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing - Gadget Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #232323; /* Dark background color */
            color: #fff; /* Light text color */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto; /* Center the container horizontally */
        }
        .card {
            background-color: #2c2c2c; /* Dark card background */
            color: #fff; /* Light text color */
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(255,255,255,0.1); /* Light box shadow */
        }
        .card:hover {
            box-shadow: 0 0 15px rgba(255,255,255,0.3); /* Darker box shadow on hover */
        }
        .card-img-top {
            height: 300px; /* Adjust height as per your product image aspect ratio */
            object-fit: cover;
        }
        .btn-primary, .btn-success, .btn-danger {
            background-color: #007bff; /* Amazon-like blue for primary actions */
            border-color: #007bff;
        }
        .btn-primary:hover, .btn-success:hover, .btn-danger:hover {
            background-color: #0056b3; /* Darker shade on hover */
            border-color: #0056b3;
        }
        .modal-content {
            background-color: #2c2c2c; /* Dark modal background */
            color: #fff; /* Light text color */
            border: 1px solid rgba(255,255,255,0.1); /* Light border */
        }
        .modal-header {
            border-bottom: 1px solid rgba(255,255,255,0.1); /* Light border bottom for header */
        }
        .modal-footer {
            border-top: 1px solid rgba(255,255,255,0.1); /* Light border top for footer */
        }
        .form-control {
            background-color: #343a40; /* Dark input background */
            color: #fff; /* Light text color */
            border: 1px solid rgba(255,255,255,0.1); /* Light border */
        }
        .form-control:focus {
            background-color: #495057; /* Darker shade on focus */
            border-color: #495057;
            color: #fff; /* Light text color */
        }
        .close {
            color: #fff; /* Light close button color */
        }
        .btn-secondary {
            background-color: #6c757d; /* Secondary button background */
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268; /* Darker shade on hover */
            border-color: #545b62;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="text-center mb-5">GadgetHub</h1>
        <!-- Add New Product Button -->
        <button class="btn btn-success mb-4" data-toggle="modal" data-target="#addProductModal">Add New Product</button>

        <div class="row justify-content-center" id="productList">
            <!-- Product cards will be dynamically added here -->
        </div>

        <!-- Modal for Add New Product -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addProductForm">
                        <div class="modal-body">
                            @csrf <!-- CSRF token for Laravel -->
                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="productDescription">Product Description</label>
                                <textarea class="form-control" id="productDescription" name="description" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="productPrice">Price ($)</label>
                                <input type="number" class="form-control" id="productPrice" name="price" step="0.01" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Update/Delete Product -->
        <div class="modal fade" id="productActionModal" tabindex="-1" role="dialog" aria-labelledby="productActionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productActionModalLabel">Product Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="updateProductForm">
                        <div class="modal-body">
                            @csrf <!-- CSRF token for Laravel -->
                            <input type="hidden" id="productId" name="id">
                            <div class="form-group">
                                <label for="productNameUpdate">Product Name</label>
                                <input type="text" class="form-control" id="productNameUpdate" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="productDescriptionUpdate">Product Description</label>
                                <textarea class="form-control" id="productDescriptionUpdate" name="description" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="productPriceUpdate">Price ($)</label>
                                <input type="number" class="form-control" id="productPriceUpdate" name="price" step="0.01" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger float-left" id="deleteProductBtn">Delete Product</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="successMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to remove modal backdrop after modal is hidden
            function removeModalBackdrop(modalId) {
                $('#' + modalId).on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            }

            // Fetch and display products on page load
            fetchProducts();

            // Function to fetch products
            function fetchProducts() {
                $.ajax({
                    url: '/api/products',
                    type: 'GET',
                    success: function(response) {
                        displayProducts(response);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        alert('Error fetching products. Please try again.');
                    }
                });
            }

            // Function to display products in the UI
            function displayProducts(products) {
                var productList = $('#productList');
                productList.empty(); // Clear previous list
                products.forEach(function(product) {
                    productList.append(`
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <img src="${product.image_url}" class="card-img-top" alt="${product.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">${product.description}</p>
                                    <p class="card-text">Price: $${product.price}</p>
                                    <button class="btn btn-primary btn-sm view-product-btn" data-toggle="modal" data-target="#productActionModal" data-id="${product.id}" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}">View Product</button>
                                </div>
                            </div>
                        </div>
                    `);
                });
            }

            // Handle click on "View Product" button to populate update/delete modal
            $('#productList').on('click', '.view-product-btn', function() {
                var productId = $(this).data('id');
                var productName = $(this).data('name');
                var productDescription = $(this).data('description');
                var productPrice = $(this).data('price');

                $('#productId').val(productId);
                $('#productNameUpdate').val(productName);
                $('#productDescriptionUpdate').val(productDescription);
                $('#productPriceUpdate').val(productPrice);
            });

            // Handle click on "Delete Product" button in modal
            $('#deleteProductBtn').click(function() {
                var productId = $('#productId').val();

                $.ajax({
                    url: '/api/products/' + productId,
                    type: 'DELETE',
                    success: function(response) {
                        $('#productActionModal').modal('hide');
                        $('#successMessage').text('Product deleted successfully!');
                        $('#successModal').modal('show');
                        removeModalBackdrop('productActionModal');
                        fetchProducts(); // Refresh product list after deletion
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        alert('Error deleting product. Please try again.');
                    }
                });
            });

            // Handle form submission for updating a product
            $('#updateProductForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var productId = $('#productId').val();

                $.ajax({
                    url: '/api/products/' + productId,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#productActionModal').modal('hide');
                        $('#successMessage').text('Product updated successfully!');
                        $('#successModal').modal('show');
                        removeModalBackdrop('productActionModal');
                        fetchProducts(); // Refresh product list after update
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        alert('Error updating product. Please try again.');
                    }
                });
            });

            // Handle form submission for adding a new product
            $('#addProductForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '/api/products',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addProductModal').modal('hide');
                        $('#successMessage').text('Product added successfully!');
                        $('#successModal').modal('show');
                        removeModalBackdrop('addProductModal');
                        fetchProducts(); // Refresh product list after addition
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        alert('Error adding product. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
@endsection
