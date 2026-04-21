<header class="border-b border-slate-200 bg-white px-4 py-3 md:px-6">
    <div class="flex items-center justify-between">
        <h2 class="text-sm text-slate-500">@yield('title', 'Dashboard')</h2>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="admin-btn admin-btn-secondary">Logout</button>
        </form>
    </div>
</header>
