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
                        <th>Currency</th>
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
                        <td>
                            @if($m->image_data)
                                <img src="data:{{ $m->image_type }};base64,{{ $m->image_data }}" style="width:24px;height:24px;border-radius:6px;object-fit:cover;vertical-align:middle;margin-right:6px;" alt="">
                            @endif
                            <strong>{{ $m->name }}</strong>
                        </td>
                        <td>{{ $m->currency }}</td>
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
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary editBtn"
                                    data-id="{{ $m->id }}"
                                    data-name="{{ $m->name }}"
                                    data-phone="{{ $m->phone_number }}"
                                    data-currency="{{ $m->currency }}"
                                    data-min="{{ $m->min_amount }}"
                                    data-max="{{ $m->max_amount }}"
                                    data-fixed="{{ $m->fixed_charge }}"
                                    data-percent="{{ $m->percent_charge }}"
                                    data-desc="{{ $m->description }}"
                                    data-status="{{ $m->status }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.deposits.methods.toggle.status', $m->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-{{ $m->status == 1 ? 'warning' : 'success' }}" title="{{ $m->status == 1 ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $m->status == 1 ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.deposits.methods.delete', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No deposit methods found. Add one to get started.</td>
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
            <form id="methodForm" method="POST" action="{{ route('admin.deposits.methods.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Deposit Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="methodId">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="methodName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number <small class="text-muted">(TeleBirr number for receiving payments)</small></label>
                        <input type="text" name="phone_number" id="methodPhone" class="form-control" placeholder="e.g. 900298059">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Currency</label>
                        <input type="text" name="currency" id="methodCurrency" class="form-control" value="ETB" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Min Amount</label>
                            <input type="number" step="any" name="min_amount" id="methodMin" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Max Amount</label>
                            <input type="number" step="any" name="max_amount" id="methodMax" class="form-control" required>
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
                        <label class="form-label">Description</label>
                        <textarea name="description" id="methodDesc" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image (QR code or icon)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
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
        modal.find('#modalTitle').text('Edit Deposit Method');
        modal.find('#methodId').val($(this).data('id'));
        modal.find('#methodName').val($(this).data('name'));
        modal.find('#methodPhone').val($(this).data('phone') || '');
        modal.find('#methodCurrency').val($(this).data('currency') || 'ETB');
        modal.find('#methodMin').val($(this).data('min'));
        modal.find('#methodMax').val($(this).data('max'));
        modal.find('#methodFixed').val($(this).data('fixed'));
        modal.find('#methodPercent').val($(this).data('percent'));
        modal.find('#methodDesc').val($(this).data('desc') || '');
        modal.find('#methodForm').attr('action', '{{ route("admin.deposits.methods.store", ":id") }}'.replace(':id', $(this).data('id')));
        modal.modal('show');
    });
    $('#methodModal').on('hidden.bs.modal', function() {
        $(this).find('#modalTitle').text('Add Deposit Method');
        $(this).find('#methodId').val('');
        $(this).find('#methodName').val('');
        $(this).find('#methodPhone').val('');
        $(this).find('#methodCurrency').val('ETB');
        $(this).find('#methodMin').val('');
        $(this).find('#methodMax').val('');
        $(this).find('#methodFixed').val('');
        $(this).find('#methodPercent').val('');
        $(this).find('#methodDesc').val('');
        $(this).find('#methodForm').attr('action', '{{ route("admin.deposits.methods.store") }}');
    });
</script>
@endpush
