@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <span>{{ $pageTitle }}</span>
            <form action="" method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm" style="width:250px">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, username or phone" value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-tabs px-3 pt-3">
            <li class="nav-item">
                <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.users.all') }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'active' ? 'active' : '' }}" href="{{ route('admin.users.all', ['status' => 'active']) }}">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'banned' ? 'active' : '' }}" href="{{ route('admin.users.all', ['status' => 'banned']) }}">Banned</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'activated' ? 'active' : '' }}" href="{{ route('admin.users.all', ['status' => 'activated']) }}">Activated</a>
            </li>
        </ul>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td>
                            <strong>{{ $u->fullname() }}</strong>
                        </td>
                        <td><span class="text-muted">@</span>{{ $u->username }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->mobile ?? 'N/A' }}</td>
                        <td>{{ showAmount($u->balance) }}</td>
                        <td>
                            @if($u->status == 1)
                                <span class="badge bg-soft-success">Active</span>
                            @else
                                <span class="badge bg-soft-danger">Banned</span>
                            @endif
                            @if($u->ev == 1)
                                <span class="badge bg-soft-info">Activated</span>
                            @endif
                        </td>
                        <td>{{ showDateTime($u->created_at) }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.detail', $u->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.login', $u->id) }}" class="btn btn-sm btn-outline-warning" title="Login as" target="_blank">
                                    <i class="fas fa-sign-in-alt"></i>
                                </a>
                                @if($u->status == 1)
                                    <form action="{{ route('admin.users.toggle.status', $u->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger" title="Ban User" type="submit">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.toggle.status', $u->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success" title="Unban User" type="submit">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No users found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
