<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Products</title>
    <!-- Combined styles -->
    <link rel="stylesheet" href="{{ asset('css/admin-crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-products.css') }}">
</head>
<body>
    @php
        // Dummy data for prototype – remove when connecting to real backend
        $dummyProducts = [
            (object)[
                'id' => 1,
                'name' => 'Sample Product 1',
                'price' => 29.99,
                'category' => (object)['name' => 'Electronics'],
                'is_featured' => true,
                'image_url' => 'https://via.placeholder.com/50'
            ],
            (object)[
                'id' => 2,
                'name' => 'Sample Product 2',
                'price' => 49.99,
                'category' => (object)['name' => 'Clothing'],
                'is_featured' => false,
                'image_url' => 'https://via.placeholder.com/50'
            ],
            (object)[
                'id' => 3,
                'name' => 'Sample Product 3',
                'price' => 99.99,
                'category' => (object)['name' => 'Home & Garden'],
                'is_featured' => true,
                'image_url' => 'https://via.placeholder.com/50'
            ],
        ];
        
        $dummyCategories = [
            (object)['id' => 1, 'name' => 'Electronics'],
            (object)['id' => 2, 'name' => 'Clothing'],
            (object)['id' => 3, 'name' => 'Home & Garden'],
            (object)['id' => 4, 'name' => 'Books'],
            (object)['id' => 5, 'name' => 'Toys'],
        ];
        
        // Use dummy data if real data isn't passed
        $products = $products ?? $dummyProducts;
        $categories = $categories ?? $dummyCategories;
    @endphp

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <ul class="nav">
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
                    <a href="#" onclick="event.preventDefault(); alert('Logout would happen here.');">Logout</a>
                </div>
            </header>

            <!-- Page Content -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Products content (original @section('content') from second script) -->
            <div class="container">
                <h1>Manage Products</h1>
                <button class="btn btn-primary" onclick="openModal('create')">Add New Product</button>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Featured</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                            <td><img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="50"></td>
                            <td>
                                <button class="btn btn-sm btn-edit" onclick="openModal('edit', {{ $product->id }})">Edit</button>
                                <button class="btn btn-sm btn-delete" onclick="confirmDelete({{ $product->id }})">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Dummy pagination -->
                <div class="pagination">
                    <ul class="pagination">
                        <li><a href="#">&laquo;</a></li>
                        <li class="active"><span>1</span></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div> <!-- end .container -->

            <!-- Modals (originally outside container but still inside main content) -->
            <!-- Modal for Create/Edit -->
            <div id="productModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 id="modalTitle">Add Product</h2>
                    <form id="productForm" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); alert('Form submission disabled in prototype. In production, this would save the product.');">
                        @csrf
                        <input type="hidden" name="_method" id="methodField" value="POST">
                        <input type="hidden" name="product_id" id="productId">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" required maxlength="255" value="Sample Product">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="4">This is a sample product description for the prototype.</textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" step="0.01" min="0" required value="29.99">
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" accept="image/*">
                            <div id="imagePreview" style="margin-top: 10px;"></div>
                        </div>

                        <div class="form-group">
                            <label for="is_featured">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1"> Featured
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="deleteModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close" onclick="closeDeleteModal()">&times;</span>
                    <h2>Confirm Delete</h2>
                    <p>Are you sure you want to delete this product?</p>
                    <form id="deleteForm" onsubmit="event.preventDefault(); alert('Delete disabled in prototype. In production, this would delete the product.'); closeDeleteModal();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Combined scripts (stack order preserved: custom JS before admin.js) -->
    <script src="{{ asset('js/admin-products.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>