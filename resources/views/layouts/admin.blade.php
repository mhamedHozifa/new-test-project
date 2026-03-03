<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Products')</title>
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <ul class="nav">
                <!-- Use plain links for prototype; adjust href when routes are defined -->
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="/admin/products" class="active">Products</a></li>
                <li><a href="/admin/categories">Categories</a></li>
                <li><a href="/admin/orders">Orders</a></li>
                <li><a href="/admin/customers">Customers</a></li>
                <li><a href="/admin/settings">Settings</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="top-bar">
                <div class="user-info">
                    <span>Welcome, Admin</span>
                    <!-- Logout link – works only if logout route exists -->
                    <a href="#" onclick="event.preventDefault(); alert('Logout would happen here.');">Logout</a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>