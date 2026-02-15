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
            <div class="col-lg-4 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Add Product</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf
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
                                    autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="productImage" name="image"
                                    accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price ($)</label>
                                <input type="number" class="form-control" id="productPrice" name="price"
                                    step="0.01" min="0" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="col-lg-8 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Products List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ Str::substr($product->description, 0, 15) }}.....</td>
                                            <td><img src="{{ asset('images/' . $product->product_image) }}"
                                                    alt="Product" class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover;"></td>
                                            <td>${{ $product->price }}</td>
                                            <td class="d-flex">
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="btn btn-sm btn-warning me-1">Edit</a>
                                                <form method="POST"
                                                    action="{{ route('product.destroy', $product->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            No Product Found!
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- Display the pagination links -->
                            <div class="d-flex justify-content-start mx-2 mt-2">
                                {!! $products->links() !!}
                            </div>
                        </div>
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
