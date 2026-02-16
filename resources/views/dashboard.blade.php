<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-light">

    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ url('/dashboard') }}">
                <i class="fas fa-store me-2"></i>Product Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-3">
                        <a href="{{ route('cart.product') }}" class="btn btn-light position-relative">
                            <i class="fas fa-shopping-cart me-1"></i> Cart
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ session()->has('cart') ? count(session('cart')) : '0' }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-light">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-boxes text-primary me-2"></i>All Products
                </h2>
                <p class="text-muted">Browse our collection of quality products</p>
            </div>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @php
            $products = \App\Models\Product::all();
        @endphp

        <!-- Products Section -->
        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <!-- Product Image -->
                        <div class="text-center p-4 bg-white">
                            <img src="{{ asset('images/' . $product->product_image) }}" class="img-fluid"
                                style="max-height: 200px; object-fit: contain;" alt="{{ $product->product_name }}">
                        </div>

                        <!-- Product Details -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark mb-2">
                                {{ $product->product_name }}
                            </h5>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            <!-- Price and Action -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="h4 text-success mb-0 fw-bold">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <span class="badge bg-primary">In Stock</span>
                                </div>
                                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                    @csrf
                                    <button class="btn btn-primary w-100">
                                        <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-12">
                    <div class="alert alert-info text-center py-5" role="alert">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        <h4 class="alert-heading">No Products Available</h4>
                        <p class="mb-0">There are currently no products in the store. Please check back later!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">
                        <i class="fas fa-copyright me-1"></i>2024 Product Store. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>
