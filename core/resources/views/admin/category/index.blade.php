@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $pageTitle }}
        <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#categoryModal">
            <i class="fas fa-plus"></i> Add New
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Tasks Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $c)
                    <tr>
                        <td><strong>{{ $c->name }}</strong></td>
                        <td><span class="text-muted">{{ $c->slug }}</span></td>
                        <td>
                            @if($c->status == 1)
                                <span class="badge bg-soft-success">Active</span>
                            @else
                                <span class="badge bg-soft-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $c->tasks_count ?? $c->tasks()->count() }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary editBtn" data-id="{{ $c->id }}" data-name="{{ $c->name }}" data-slug="{{ $c->slug }}" data-status="{{ $c->status }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.category.delete', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No categories found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
    @endif
</div>

<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="categoryForm" method="POST" action="{{ route('admin.category.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="categoryId">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="categoryName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" id="categorySlug" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="categoryStatus" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $('.editBtn').on('click', function() {
        const modal = $('#categoryModal');
        modal.find('#modalTitle').text('Edit Category');
        modal.find('#categoryId').val($(this).data('id'));
        modal.find('#categoryName').val($(this).data('name'));
        modal.find('#categorySlug').val($(this).data('slug'));
        modal.find('#categoryStatus').val($(this).data('status'));
        modal.find('#categoryForm').attr('action', '{{ route("admin.category.store") }}');
        modal.modal('show');
    });
    $('#categoryModal').on('hidden.bs.modal', function() {
        $(this).find('#modalTitle').text('Add Category');
        $(this).find('#categoryId').val('');
        $(this).find('#categoryName').val('');
        $(this).find('#categorySlug').val('');
        $(this).find('#categoryStatus').val('1');
        $(this).find('#categoryForm').attr('action', '{{ route("admin.category.store") }}');
    });
</script>
@endpush
