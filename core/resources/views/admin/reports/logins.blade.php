@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $pageTitle }}
        <form action="" method="GET" class="float-end d-flex gap-2">
            <div class="input-group input-group-sm" style="width:200px">
                <input type="text" name="search" class="form-control" placeholder="Search user or phone number" value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
            <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}" style="width:160px">
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>IP</th>
                        <th>Browser</th>
                        <th>OS</th>
                        <th>Country</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logins as $l)
                    <tr>
                        <td>{{ $l->user?->fullname() ?? 'N/A' }}</td>
                        <td><span class="text-muted">{{ $l->ip }}</span></td>
                        <td>{{ $l->browser ?? 'N/A' }}</td>
                        <td>{{ $l->os ?? 'N/A' }}</td>
                        <td>{{ $l->country ?? 'N/A' }}</td>
                        <td>{{ showDateTime($l->created_at) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No login history found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($logins->hasPages())
    <div class="card-footer">
        {{ $logins->links() }}
    </div>
    @endif
</div>
@endsection
