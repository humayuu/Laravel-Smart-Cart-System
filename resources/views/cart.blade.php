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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/dashboard') }}">
                            <i class="fas fa-home me-1"></i>Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-light ms-2">
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
                <h2 class="fw-bold text-dark mb-1">
                    <i class="fas fa-shopping-cart text-primary me-2"></i>Shopping Cart
                </h2>
                <p class="text-muted">Review and manage your cart items</p>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @php
            $total = 0;
        @endphp

        @if (count($carts) > 0)
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col" style="width: 150px;">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $key => $cart)
                                    @php
                                        $subtotal = $cart['price'] * $cart['quantity'];
                                        $total += $subtotal;
                                    @endphp
                                    <tr id="row-{{ $key }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('images/' . $cart['image']) }}" class="rounded me-3"
                                                    width="80" height="80" style="object-fit: cover;"
                                                    alt="{{ $cart['name'] }}">
                                                <div>
                                                    <h6 class="mb-0">{{ $cart['name'] }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">${{ number_format($cart['price'], 2) }}</span>
                                        </td>
                                        <td>
                                            <form method="POST" action="#" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <div class="input-group input-group-sm" style="max-width: 120px;">
                                                    <input type="number" name="quantity"
                                                        value="{{ $cart['quantity'] }}"
                                                        class="form-control text-center" min="1" max="99">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <span
                                                class="fw-bold text-primary">${{ number_format($subtotal, 2) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <button onclick="removeCart('{{ $key }}')"
                                                class="btn btn-outline-danger btn-sm" type="submit">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div id="total" class="row mt-4">
                <div class="col-lg-4 ms-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Cart Summary</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Items:</span>
                                <span class="fw-semibold">{{ count($carts) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="h5 mb-0">Total:</span>
                                <span class="h4 mb-0 text-primary fw-bold">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-lg">
                                    <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                                </button>
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart text-muted" style="font-size: 80px;"></i>
                </div>
                <h4 class="text-muted mb-3">Your cart is empty</h4>
                <p class="text-muted mb-4">Add some products to your cart to see them here.</p>
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <p class="mb-0">
                        <i class="fas fa-copyright me-1"></i>2024 Product Store. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white text-decoration-none me-3">
                        <i class="fas fa-shield-alt me-1"></i>Privacy
                    </a>
                    <a href="#" class="text-white text-decoration-none">
                        <i class="fas fa-file-contract me-1"></i>Terms
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        let divEl = document.getElementById('total');
        const removeCart = async (id) => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(async (result) => {
                if (result.isConfirmed) {

                    try {
                        const response = await fetch(`/cart/remove/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        // Remove the row from DOM
                        document.getElementById(`row-${id}`).remove();


                        // Show success message
                        Swal.fire({
                            title: "Deleted!",
                            text: data.message ?? "Item removed from cart.",
                            icon: "success"
                        });

                    } catch (error) {
                        console.log(error);
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong.",
                            icon: "error"
                        });
                    }

                }
            });
        }
    </script>
</body>

</html>
