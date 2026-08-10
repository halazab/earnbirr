@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $pageTitle }}
        <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#methodModal">
            <i class="fas fa-plus"></i> Add Method
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Fixed Charge</th>
                        <th>Percent Charge</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($methods as $m)
                    <tr>
                        <td><strong>{{ $m->name }}</strong></td>
                        <td>{{ showAmount($m->min_amount) }}</td>
                        <td>{{ showAmount($m->max_amount) }}</td>
                        <td>{{ showAmount($m->fixed_charge) }}</td>
                        <td>{{ $m->percent_charge }}%</td>
                        <td>
                            @if($m->status == 1)
                                <span class="badge bg-soft-success">Active</span>
                            @else
                                <span class="badge bg-soft-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary editBtn"
                                data-id="{{ $m->id }}"
                                data-name="{{ $m->name }}"
                                data-min="{{ $m->min_amount }}"
                                data-max="{{ $m->max_amount }}"
                                data-fixed="{{ $m->fixed_charge }}"
                                data-percent="{{ $m->percent_charge }}"
                                data-status="{{ $m->status }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.withdrawals.methods.delete', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No withdrawal methods found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($methods->hasPages())
    <div class="card-footer">
        {{ $methods->links() }}
    </div>
    @endif
</div>

<div class="modal fade" id="methodModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="methodForm" method="POST" action="{{ route('admin.withdrawals.methods.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="methodId">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="methodName" class="form-control" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Min Amount</label>
                            <input type="number" step="any" name="min_limit" id="methodMin" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Max Amount</label>
                            <input type="number" step="any" name="max_limit" id="methodMax" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Fixed Charge</label>
                            <input type="number" step="any" name="fixed_charge" id="methodFixed" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Percent Charge (%)</label>
                            <input type="number" step="any" name="percent_charge" id="methodPercent" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="methodStatus" class="form-control" required>
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
        const modal = $('#methodModal');
        modal.find('#modalTitle').text('Edit Method');
        modal.find('#methodId').val($(this).data('id'));
        modal.find('#methodName').val($(this).data('name'));
        modal.find('#methodMin').val($(this).data('min'));
        modal.find('#methodMax').val($(this).data('max'));
        modal.find('#methodFixed').val($(this).data('fixed'));
        modal.find('#methodPercent').val($(this).data('percent'));
        modal.find('#methodStatus').val($(this).data('status'));
        modal.find('#methodForm').attr('action', '{{ route("admin.withdrawals.methods.store", ":id") }}'.replace(':id', $(this).data('id')));
        modal.modal('show');
    });
    $('#methodModal').on('hidden.bs.modal', function() {
        $(this).find('#modalTitle').text('Add Method');
        $(this).find('#methodId').val('');
        $(this).find('#methodName').val('');
        $(this).find('#methodMin').val('');
        $(this).find('#methodMax').val('');
        $(this).find('#methodFixed').val('');
        $(this).find('#methodPercent').val('');
        $(this).find('#methodStatus').val('1');
        $(this).find('#methodForm').attr('action', '{{ route("admin.withdrawals.methods.store") }}');
    });
</script>
@endpush
