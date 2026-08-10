@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">{{ $pageTitle }}</div>
    <div class="card-body">
        <form action="{{ route('admin.profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <img src="{{ getImage(getFilePath('adminProfile'), auth()->guard('admin')->user()->image) }}" class="rounded-circle" width="150" height="150" alt="">
                    </div>
                    <label class="form-label d-block">Profile Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Supported: jpg, jpeg, png. Max 2MB.</small>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->guard('admin')->user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ auth()->guard('admin')->user()->email }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
