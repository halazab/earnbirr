@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $pageTitle }}
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-outline-secondary float-end">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ $action }}" method="POST">
            @csrf
            @if($task)
                @method('PUT')
            @endif
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id', $task?->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Task Type</label>
                    <select name="task_type" class="form-control" required>
                        <option value="social_media" {{ old('task_type', $task?->task_type) == 'social_media' ? 'selected' : '' }}>Social Media</option>
                        <option value="micro_task" {{ old('task_type', $task?->task_type) == 'micro_task' ? 'selected' : '' }}>Micro Task</option>
                        <option value="daily_claim" {{ old('task_type', $task?->task_type) == 'daily_claim' ? 'selected' : '' }}>Daily Claim</option>
                        <option value="survey" {{ old('task_type', $task?->task_type) == 'survey' ? 'selected' : '' }}>Survey</option>
                        <option value="freelance" {{ old('task_type', $task?->task_type) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $task?->title) }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $task?->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Reward</label>
                    <input type="number" step="any" name="reward" class="form-control" value="{{ old('reward', $task?->reward) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Total Slots</label>
                    <input type="number" name="total_slots" class="form-control" value="{{ old('total_slots', $task?->total_slots) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Proof Types <small class="text-muted">(select one or more)</small></label>
                    <div class="d-flex flex-wrap gap-3 mt-1">
                        @php $selected = old('proof_type', $task?->proof_type ?? []); @endphp
                        <label class="form-check-label d-flex align-items-center gap-1">
                            <input type="checkbox" name="proof_type[]" value="link" class="form-check-input" {{ in_array('link', (array)$selected) ? 'checked' : '' }}>
                            Link
                        </label>
                        <label class="form-check-label d-flex align-items-center gap-1">
                            <input type="checkbox" name="proof_type[]" value="file" class="form-check-input" {{ in_array('file', (array)$selected) ? 'checked' : '' }}>
                            File Upload
                        </label>
                        <label class="form-check-label d-flex align-items-center gap-1">
                            <input type="checkbox" name="proof_type[]" value="text" class="form-check-input" {{ in_array('text', (array)$selected) ? 'checked' : '' }}>
                            Text
                        </label>
                        <label class="form-check-label d-flex align-items-center gap-1">
                            <input type="checkbox" name="proof_type[]" value="screenshot" class="form-check-input" {{ in_array('screenshot', (array)$selected) ? 'checked' : '' }}>
                            Screenshot
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Date</label>
                    <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', $task?->end_date ? $task->end_date->format('Y-m-d\TH:i') : '') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Instructions</label>
                    <textarea name="instructions" class="form-control" rows="3">{{ old('instructions', $task?->instructions) }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label">External Link</label>
                    <input type="url" name="external_link" class="form-control" value="{{ old('external_link', $task?->external_link) }}" placeholder="https://...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Task File <small class="text-muted">(optional - images, PDFs, docs)</small></label>
                    <input type="file" name="task_file" class="form-control" accept="image/*,.pdf,.doc,.docx,.txt,.zip,.rar" {{ $task && $task->task_file ? '' : '' }}>
                    @if($task && $task->task_file_data)
                        <div class="mt-2">
                            @if(str_starts_with($task->task_file_type, 'image/'))
                                <img src="data:{{ $task->task_file_type }};base64,{{ $task->task_file_data }}" style="max-width:200px;max-height:150px;border-radius:8px;" alt="{{ $task->task_file }}">
                            @else
                                <small class="text-muted">Current: <a href="data:{{ $task->task_file_type }};base64,{{ $task->task_file_data }}" target="_blank" download="{{ $task->task_file }}">{{ $task->task_file }}</a></small>
                            @endif
                        </div>
                    @endif
                    <small class="text-muted">Max 10MB. Accepted: images, PDF, docs, archives.</small>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
