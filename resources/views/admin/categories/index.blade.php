@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Categories</h1>
            <button class="admin-btn admin-btn-primary" onclick="openModal('create')">Add Category</button>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Products Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($category->description, 50) }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td class="space-x-2">
                                <button class="admin-btn admin-btn-secondary" onclick="openModal('edit', {{ $category->id }})">Edit</button>
                                <button class="admin-btn admin-btn-danger" onclick="confirmDelete({{ $category->id }})">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-slate-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="categoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4">
        <div class="w-full max-w-lg rounded-lg bg-white p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 id="modalTitle" class="text-lg font-semibold">Add Category</h2>
                <button class="text-slate-500" onclick="closeModal()">&times;</button>
            </div>

            <form id="categoryForm" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <div class="admin-form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="admin-input" required>
                </div>
                <div class="admin-form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="3" class="admin-input"></textarea>
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
    const categoryModal = document.getElementById('categoryModal');

    function openModal(action, categoryId = null) {
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('categoryForm');
        const methodField = document.getElementById('methodField');

        if (action === 'create') {
            modalTitle.innerText = 'Add Category';
            form.action = "{{ route('admin.categories.store') }}";
            methodField.value = 'POST';
            document.getElementById('name').value = '';
            document.getElementById('description').value = '';
        } else if (action === 'edit' && categoryId) {
            modalTitle.innerText = 'Edit Category';
            form.action = `/admin/categories/${categoryId}`;
            methodField.value = 'PUT';

            fetch(`{{ url('/admin/categories') }}/${categoryId}/edit-data`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name').value = data.name;
                    document.getElementById('description').value = data.description ?? '';
                })
                .catch(error => console.error('Error:', error));
        }
        categoryModal.classList.remove('hidden');
        categoryModal.classList.add('flex');
    }

    function closeModal() {
        categoryModal.classList.add('hidden');
        categoryModal.classList.remove('flex');
    }

    function confirmDelete(categoryId) {
        if (confirm('Are you sure you want to delete this category?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/categories/${categoryId}`;
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

    window.onclick = function(event) {
        if (event.target === categoryModal) {
            closeModal();
        }
    };
</script>
@endpush
@endsection