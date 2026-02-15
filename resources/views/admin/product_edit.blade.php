<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">ADMIN DASHBOARD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button class="btn btn-outline-light">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row g-4">
            <!-- Add Product Form -->
            <div class="col-lg-6 mx-auto col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Product</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('product.update', $product->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="name" required
                                    autofocus value="{{ $product->product_name }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="productImage" name="image"
                                    accept="image/*">
                                <img src="{{ asset('images/' . $product->product_image) }}" width="100"
                                    alt="">
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price ($)</label>
                                <input type="number" class="form-control" id="productPrice" name="price"
                                    step="0.01" min="0" required value="{{ $product->price }}">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
