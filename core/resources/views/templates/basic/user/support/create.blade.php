@extends('templates.basic.layouts.app')

@section('title', 'Create Ticket')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('user.ticket.index') }}" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:border-emerald-300 hover:text-emerald-500 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Create Ticket</h1>
                <p class="text-gray-500 text-sm mt-0.5">Submit a support request</p>
            </div>
        </div>

        <div class="card p-6 lg:p-8">
            <form method="POST" action="{{ route('user.ticket.store') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-input" placeholder="Brief description of your issue" required>
                </div>

                <div class="mt-5">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-input" required>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <div class="mt-5">
                    <label class="form-label">Message</label>
                    <textarea name="message" rows="6" class="form-input resize-none" placeholder="Describe your issue in detail..." required></textarea>
                </div>

                <div class="mt-5">
                    <label class="form-label">Attachment (optional)</label>
                    <input type="file" name="attachment" class="form-input file:text-sm file:border-0 file:bg-emerald-50 file:text-emerald-600 file:font-medium file:rounded-lg file:px-4 file:py-2 file:cursor-pointer">
                    <p class="text-xs text-gray-400 mt-1">Max 5MB. Accepted: images, PDF, docs</p>
                </div>

                <button type="submit" class="btn-primary mt-6">
                    <i class="fas fa-paper-plane"></i> Submit Ticket
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
