@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        {{ $pageTitle }}
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.frontend.content', $key) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $sections->data_values->title ?? $pageTitle }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content <small class="text-muted">(HTML supported)</small></label>
                <textarea name="content" class="form-control" rows="15">{{ $sections->data_values->content ?? '' }}</textarea>
                <small class="text-muted">Use HTML tags for formatting: &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;, &lt;em&gt;, etc.</small>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
