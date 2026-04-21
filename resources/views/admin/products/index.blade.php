@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Products</h1>
            <button class="admin-btn admin-btn-primary" onclick="openModal('create')">Add Product</button>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Featured</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>${{ number_format((float) $product->price, 2) }}</td>
                            <td>{{ $product->category?->name ?? 'N/A' }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded object-cover">
                                @else
                                    <span class="text-slate-400">No image</span>
                                @endif
                            </td>
                            <td class="space-x-2">
                                <button class="admin-btn admin-btn-secondary" onclick="openModal('edit', {{ $product->id }})">Edit</button>
                                <button class="admin-btn admin-btn-danger" onclick="confirmDelete({{ $product->id }})">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-slate-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    </div>

    <div id="productModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4">
        <div class="w-full max-w-lg rounded-lg bg-white p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 id="modalTitle" class="text-lg font-semibold">Add Product</h2>
                <button class="text-slate-500" onclick="closeModal()">&times;</button>
            </div>

            <form id="productForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">

                <div class="admin-form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required maxlength="255" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="admin-input">
                        <option value="">No Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="3" class="admin-input"></textarea>
                </div>

                <div class="admin-form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" step="0.01" min="0" required class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" min="0" value="0" class="admin-input">
                </div>

                <div class="admin-form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" accept="image/*" class="admin-input">
                    <div id="imagePreview"></div>
                </div>

                <div class="admin-form-group">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1"> Featured
                    </label>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="submit" class="admin-btn admin-btn-primary">Save</button>
                    <button type="button" class="admin-btn admin-btn-secondary" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const productModal = document.getElementById('productModal');

        function openModal(action, productId = null)
        {
            const modal = document.getElementById('productModal');
            const modalTitle = document.getElementById('modalTitle');
            const form = document.getElementById('productForm');
            const methodField = document.getElementById('methodField');

            if (action === 'create') {
                modalTitle.innerText = 'Add Product';
                form.action = "{{ route('admin.products.store') }}";
                methodField.value = 'POST';
                document.getElementById('name').value = '';
                document.getElementById('description').value = '';
                document.getElementById('price').value = '';
                document.getElementById('stock').value = 0;
                document.getElementById('category_id').value = '';
                document.getElementById('is_featured').checked = false;
                document.getElementById('imagePreview').innerHTML = '';
            } else if (action === 'edit' && productId) {
                modalTitle.innerText = 'Edit Product';
                form.action = `/admin/products/${productId}`;
                methodField.value = 'PUT';

                fetch(`{{ url('/admin/products') }}/${productId}/edit-data`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('name').value = data.name;
                        document.getElementById('description').value = data.description ?? '';
                        document.getElementById('price').value = data.price;
                        document.getElementById('stock').value = data.stock;
                        document.getElementById('category_id').value = data.category_id ?? '';
                        document.getElementById('is_featured').checked = !!data.is_featured;
                        if (data.image_url) {
                            document.getElementById('imagePreview').innerHTML = `<img src="${data.image_url}" class="h-20 w-20 rounded object-cover">`;
                        } else {
                            document.getElementById('imagePreview').innerHTML = '';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal()
        {
            productModal.classList.add('hidden');
            productModal.classList.remove('flex');
        }

        function confirmDelete(productId)
        {
            if (confirm('Are you sure you want to delete this product?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/products/${productId}`;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        window.onclick = function (event) {
            if (event.target === productModal) {
                closeModal();
            }
        };
    </script>
    @endpush
@endsection