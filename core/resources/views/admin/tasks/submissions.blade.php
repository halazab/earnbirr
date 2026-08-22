@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $pageTitle }}
        <form action="" method="GET" class="float-end d-flex gap-2 flex-wrap">
            <div class="input-group input-group-sm" style="width:200px">
                <input type="text" name="search" class="form-control" placeholder="Search user, phone or task" value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
            <input type="date" name="date_from" class="form-control form-control-sm" style="width:155px" value="{{ request('date_from') }}" title="From Date" placeholder="From Date">
            <input type="date" name="date_to" class="form-control form-control-sm" style="width:155px" value="{{ request('date_to') }}" title="To Date" placeholder="To Date">
            <button class="btn btn-outline-primary btn-sm" type="submit"><i class="fas fa-filter"></i> Filter</button>
            @if(request('search') || request('date_from') || request('date_to') || request('status'))
                <a href="{{ route('admin.tasks.submissions') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
            @endif
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-tabs px-3 pt-3">
            <li class="nav-item">
                <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.tasks.submissions') }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.tasks.submissions', ['status' => 'pending']) }}">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}" href="{{ route('admin.tasks.submissions', ['status' => 'approved']) }}">Approved</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}" href="{{ route('admin.tasks.submissions', ['status' => 'rejected']) }}">Rejected</a>
            </li>
        </ul>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Task</th>
                        <th>Reward</th>
                        <th>Proof</th>
                        <th>Status</th>
                        <th>Admin Note</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $s)
                    <tr>
                        <td>{{ $s->user?->fullname() ?? 'N/A' }}</td>
                        <td>{{ strLimit($s->task?->title ?? 'N/A', 30) }}</td>
                        <td>{{ showAmount($s->task?->reward ?? 0) }}</td>
                        <td>
                            @if($s->proof_file && is_numeric($s->proof_file))
                                <a href="/uploads/{{ $s->proof_file }}" target="_blank" class="d-inline-block">
                                    <img src="/uploads/{{ $s->proof_file }}" style="max-width:80px;max-height:60px;border-radius:6px;object-fit:cover;border:1px solid #e2e8f0;" onerror="this.parentElement.innerHTML='<a href=\'/uploads/{{ $s->proof_file }}\' target=\'_blank\' class=\'btn btn-sm btn-outline-info\'><i class=\'fas fa-file\'></i> View File</a>'" alt="proof">
                                </a>
                            @elseif($s->proof_link)
                                <a href="{{ $s->proof_link }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-external-link-alt"></i> View Link
                                </a>
                            @elseif($s->proof_text)
                                <button class="btn btn-sm btn-outline-info viewProofText" data-text="{{ $s->proof_text }}">
                                    <i class="fas fa-align-left"></i> View Text
                                </button>
                            @else
                                <span class="text-muted small">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($s->status == 0)
                                <span class="badge bg-soft-warning">Pending</span>
                            @elseif($s->status == 1)
                                <span class="badge bg-soft-success">Approved</span>
                            @else
                                <span class="badge bg-soft-danger">Rejected</span>
                            @endif
                        </td>
                        <td class="small">{{ $s->admin_note ?? '--' }}</td>
                        <td>{{ showDateTime($s->created_at) }}</td>
                        <td>
                            @if($s->status == 0)
                            <div class="d-flex gap-1">
                                <form action="{{ route('admin.tasks.submissions.approve', $s->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success" type="submit">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <button class="btn btn-sm btn-danger rejectBtn" data-id="{{ $s->id }}">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </div>
                            @else
                                <span class="text-muted small">--</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No submissions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($submissions->hasPages())
    <div class="card-footer">
        {{ $submissions->links() }}
    </div>
    @endif
</div>

    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="rejectForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Submission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Admin Note <span class="text-danger">*</span></label>
                            <textarea name="admin_note" class="form-control" rows="3" required placeholder="Reason for rejection"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="proofTextModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Proof Text</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0" id="proofTextContent"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $('.rejectBtn').on('click', function() {
        const id = $(this).data('id');
        $('#rejectForm').attr('action', '{{ route("admin.tasks.submissions.reject", ":id") }}'.replace(':id', id));
        $('#rejectModal').modal('show');
    });
    $('.viewProofText').on('click', function() {
        $('#proofTextContent').text($(this).data('text'));
        $('#proofTextModal').modal('show');
    });
</script>
@endpush
