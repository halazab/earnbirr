@extends('admin.layouts.master')
@section('content')
<div class="row g-4">
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="icon" style="background: #d1fae5;color:#065f46;">
                <i class="fas fa-users"></i>
            </div>
            <div class="label">Total Users</div>
            <div class="value">{{ $widget['total_users'] }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="icon" style="background: #dbeafe;color:#1e40af;">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="label">Active Users</div>
            <div class="value">{{ $widget['active_users'] }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="icon" style="background: #fef3c7;color:#92400e;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="label">Activated Users</div>
            <div class="value">{{ $widget['activated_users'] }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="icon" style="background: #fee2e2;color:#991b1b;">
                <i class="fas fa-ban"></i>
            </div>
            <div class="label">Banned Users</div>
            <div class="value">{{ $widget['banned_users'] }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="icon" style="background: #d1fae5;color:#065f46;">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="label">Total Tasks</div>
            <div class="value">{{ $widget['total_tasks'] }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="icon" style="background: #dbeafe;color:#1e40af;">
                <i class="fas fa-play-circle"></i>
            </div>
            <div class="label">Active Tasks</div>
            <div class="value">{{ $widget['active_tasks'] }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="icon" style="background: #fef3c7;color:#92400e;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="label">Pending Submissions</div>
            <div class="value">{{ $widget['pending_submissions'] }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="icon" style="background: #f3e8ff;color:#6b21a8;">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="label">Total Deposits</div>
            <div class="value">{{ showAmount($totalDeposits) }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="icon" style="background: #e0f2fe;color:#0369a1;">
                <i class="fas fa-gift"></i>
            </div>
            <div class="label">Today's Claims</div>
            <div class="value">{{ $todayClaims }}</div>
            <div class="text-muted small">Total: {{ $totalClaims }} | {{ showAmount($totalClaimRewards) }}</div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                Recent Users
                <a href="{{ route('admin.users.all') }}" class="btn btn-sm btn-outline-primary float-end">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $u)
                            <tr>
                                <td>
                                    <strong>{{ $u->fullname() }}</strong>
                                    <div class="text-muted small">@</div>
                                </td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    @if($u->status == 1)
                                        <span class="badge bg-soft-success">Active</span>
                                    @else
                                        <span class="badge bg-soft-danger">Banned</span>
                                    @endif
                                </td>
                                <td>{{ showDateTime($u->created_at) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">No users yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                Recent Submissions
                <a href="{{ route('admin.tasks.submissions') }}" class="btn btn-sm btn-outline-primary float-end">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSubmissions as $s)
                            <tr>
                                <td>{{ $s->user?->fullname() ?? 'N/A' }}</td>
                                <td>{{ strLimit($s->task?->title ?? 'N/A', 25) }}</td>
                                <td>
                                    @if($s->status == 0)
                                        <span class="badge bg-soft-warning">Pending</span>
                                    @elseif($s->status == 1)
                                        <span class="badge bg-soft-success">Approved</span>
                                    @else
                                        <span class="badge bg-soft-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ showDateTime($s->created_at) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">No submissions yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
