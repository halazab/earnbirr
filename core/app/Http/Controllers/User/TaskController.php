<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Available Tasks';
        $categories = TaskCategory::active()->get();
        $tasks = Task::available()->with('category');

        if ($request->category) {
            $tasks->where('category_id', $request->category);
        }
        if ($request->type) {
            $tasks->where('task_type', $request->type);
        }
        if ($request->search) {
            $tasks->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $tasks = $tasks->latest()->paginate(getPaginate());
        return view('templates.basic.user.tasks.index', compact('pageTitle', 'tasks', 'categories'));
    }

    public function details($slug)
    {
        if (!auth()->user()->activation_fee_paid) {
            return redirect()->route('user.activation');
        }
        $pageTitle = 'Task Details';
        $task = Task::available()->where('slug', $slug)->with('category')->firstOrFail();
        $alreadySubmitted = TaskSubmission::where('user_id', auth()->id())
            ->where('task_id', $task->id)
            ->whereIn('status', [0, 1])
            ->exists();
        return view('templates.basic.user.tasks.details', compact('pageTitle', 'task', 'alreadySubmitted'));
    }

    public function submit(Request $request, $id)
    {
        if (!auth()->user()->activation_fee_paid) {
            return redirect()->route('user.activation');
        }
        $task = Task::findOrFail($id);
        if ($task->status != 1 || $task->remaining_slots <= 0) {
            return back()->withErrors(['Task is no longer available.']);
        }

        $already = TaskSubmission::where('user_id', auth()->id())
            ->where('task_id', $id)
            ->whereIn('status', [0, 1])
            ->exists();
        if ($already) {
            return back()->withErrors(['You have already submitted for this task.']);
        }

        $request->validate([
            'proof_text' => 'nullable|string',
            'proof_file' => 'required|file|max:10240',
            'proof_link' => 'nullable|string',
        ]);

        $submission = new TaskSubmission();
        $submission->user_id = auth()->id();
        $submission->task_id = $task->id;
        $submission->proof_text = $request->proof_text;
        $submission->proof_link = $request->proof_link;
        $proofData = null;
        $proofType = null;
        if ($request->hasFile('proof_file')) {
            $file = $request->file('proof_file');
            $submission->proof_file = uploadFile($file);
            $proofData = base64_encode(file_get_contents($file->getRealPath()));
            $proofType = $file->getMimeType();
        }
        $submission->status = 0;
        $submission->save();

        $user = auth()->user();
        $message = "<b>📝 NEW TASK SUBMISSION</b>\n"
            . "─────────────────────\n"
            . "👤 <b>User:</b> " . ($user->name ?? 'N/A') . "\n"
            . "📱 <b>Phone:</b> " . ($user->mobile ?? 'N/A') . "\n"
            . "📧 <b>Email:</b> " . $user->email . "\n"
            . "📌 <b>Task:</b> " . $task->title . "\n"
            . "💰 <b>Reward:</b> " . showAmount($task->reward) . "\n"
            . "🏷️ <b>Type:</b> " . ucwords(str_replace('_', ' ', $task->task_type)) . "\n";

        if ($request->proof_link) {
            $message .= "🔗 <b>Proof Link:</b> " . $request->proof_link . "\n";
        }
        if ($request->proof_text) {
            $message .= "📄 <b>Proof Text:</b> " . strLimit($request->proof_text, 200) . "\n";
        }

        if ($proofData && str_starts_with($proofType ?? '', 'image/')) {
            sendTelegramMessage($message, $proofData, $proofType);
        } else {
            sendTelegramMessage($message);
        }

        $task->remaining_slots -= 1;
        if ($task->remaining_slots <= 0) {
            $task->status = 3;
        }
        $task->save();

        return redirect()->route('user.tasks.my')->with('success', 'Task submitted successfully. Waiting for review.');
    }

    public function myTasks()
    {
        $pageTitle = 'My Submissions';
        $submissions = TaskSubmission::with('task.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(getPaginate());
        return view('templates.basic.user.tasks.my', compact('pageTitle', 'submissions'));
    }
}
