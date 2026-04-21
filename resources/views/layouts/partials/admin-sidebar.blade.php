<aside class="border-r border-slate-200 bg-white">
    <div class="p-5">
        <h1 class="text-lg font-semibold">Admin Panel</h1>
        <p class="text-sm text-slate-500">E-commerce management</p>
    </div>

    <nav class="space-y-1 px-3 pb-4">
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-link-active' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'admin-nav-link-active' : '' }}">
            Products
        </a>
        <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'admin-nav-link-active' : '' }}">
            Categories
        </a>
    </nav>
</aside>
