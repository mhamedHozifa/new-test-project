@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="admin-stat-card">
            <p class="admin-stat-label">Products</p>
            <p class="admin-stat-value">{{ $productsCount }}</p>
        </div>
        <div class="admin-stat-card">
            <p class="admin-stat-label">Categories</p>
            <p class="admin-stat-value">{{ $categoriesCount }}</p>
        </div>
        <div class="admin-stat-card">
            <p class="admin-stat-label">Featured Products</p>
            <p class="admin-stat-value">{{ $featuredCount }}</p>
        </div>
        <div class="admin-stat-card">
            <p class="admin-stat-label">Low Stock (<= 5)</p>
            <p class="admin-stat-value">{{ $lowStockCount }}</p>
        </div>
    </div>
@endsection
