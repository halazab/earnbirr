<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Tasks';
        $tasks = Task::with('category')->latest()->paginate(getPaginate());
        return view('admin.tasks.index', compact('pageTitle', 'tasks'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Tasks';
        $tasks = Task::where('status', 0)->with('category')->latest()->paginate(getPaginate());
        return view('admin.tasks.index', compact('pageTitle', 'tasks'));
    }

    public function active()
    {
        $pageTitle = 'Active Tasks';
        $tasks = Task::where('status', 1)->with('category')->latest()->paginate(getPaginate());
        return view('admin.tasks.index', compact('pageTitle', 'tasks'));
    }

    public function completed()
    {
        $pageTitle = 'Completed Tasks';
        $tasks = Task::where('status', 3)->with('category')->latest()->paginate(getPaginate());
        return view('admin.tasks.index', compact('pageTitle', 'tasks'));
    }

    public function create()
    {
        $pageTitle = 'Create Task';
        $task = null;
        $action = route('admin.tasks.store');
        $categories = TaskCategory::active()->get();
        return view('admin.tasks.form', compact('pageTitle', 'action', 'categories', 'task'));
    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'category_id' => 'required|exists:task_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'task_type' => 'required|in:social_media,micro_task,daily_claim,survey,freelance',
            'reward' => 'required|numeric|gt:0',
            'total_slots' => 'required|integer|gt:0',
            'proof_type' => 'required|array|min:1',
            'proof_type.*' => 'in:screenshot,text,file,link',
            'instructions' => 'nullable|string',
            'external_link' => 'nullable|string',
            'end_date' => 'nullable|date',
        ]);

        $task = $id ? Task::findOrFail($id) : new Task();
        $task->category_id = $request->category_id;
        $task->title = $request->title;
        $task->slug = Str::slug($request->title) . ($id ? '' : '-' . time());
        $task->description = $request->description;
        $task->instructions = $request->input('instructions') ?: null;
        $task->task_type = $request->task_type;
        $task->reward = $request->reward;
        $task->total_slots = $request->total_slots;
        if (!$id) {
            $task->remaining_slots = $request->total_slots;
        }
        $task->external_link = $request->input('external_link') ?: null;
        $task->proof_type = json_encode($request->proof_type);
        $task->end_date = $request->input('end_date') ?: null;

        if ($request->hasFile('task_file')) {
            $file = $request->file('task_file');
            $task->task_file = $file->getClientOriginalName();
            $task->task_file_data = base64_encode(file_get_contents($file->getRealPath()));
            $task->task_file_type = $file->getMimeType();
        }

        $task->status = 1;
        $task->save();

        $message = $id ? 'Task updated successfully.' : 'Task created successfully.';
        return redirect()->route('admin.tasks.index')->with('success', $message);
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Task';
        $task = Task::findOrFail($id);
        $action = route('admin.tasks.store', $task->id);
        $categories = TaskCategory::active()->get();
        return view('admin.tasks.form', compact('pageTitle', 'task', 'action', 'categories'));
    }

    public function toggleStatus($id)
    {
        $task = Task::findOrFail($id);
        $task->status = match ($task->status) {
            0 => 1,
            1 => 2,
            2 => 1,
            3 => 1,
            default => 1,
        };
        $task->save();
        return back()->with('success', 'Task status updated.');
    }

    public function delete($id)
    {
        Task::findOrFail($id)->delete();
        return back()->with('success', 'Task deleted.');
    }

    public function submissions()
    {
        $pageTitle = 'All Submissions';
        $submissions = $this->applySubmissionSearch(TaskSubmission::query())->with(['user', 'task'])->latest()->paginate(getPaginate());
        return view('admin.tasks.submissions', compact('pageTitle', 'submissions'));
    }

    public function pendingSubmissions()
    {
        $pageTitle = 'Pending Submissions';
        $submissions = $this->applySubmissionSearch(TaskSubmission::pending())->with(['user', 'task'])->latest()->paginate(getPaginate());
        return view('admin.tasks.submissions', compact('pageTitle', 'submissions'));
    }

    protected function applySubmissionSearch($query)
    {
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('task', function ($task) use ($search) {
                    $task->where('title', 'like', "%{$search}%");
                })->orWhereHas('user', function ($user) use ($search) {
                    $user->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                });
            });
        }
        return $query;
    }

    public function approveSubmission($id)
    {
        $submission = TaskSubmission::with('task')->findOrFail($id);
        $submission->status = 1;
        $submission->save();

        $user = $submission->user;
        $user->balance += $submission->task->reward;
        $user->total_earned += $submission->task->reward;
        $user->save();

        $trx = 'TRX' . time() . rand(1000, 9999);
        $transaction = new \App\Models\Transaction();
        $transaction->user_id = $user->id;
        $transaction->trx = $trx;
        $transaction->amount = $submission->task->reward;
        $transaction->charge = 0;
        $transaction->post_balance = $user->balance;
        $transaction->type = 'credit';
        $transaction->remark = 'task_reward';
        $transaction->details = 'Reward for task: ' . $submission->task->title;
        $transaction->save();

        return back()->with('success', 'Submission approved and reward credited.');
    }

    public function rejectSubmission(Request $request, $id)
    {
        $request->validate(['admin_note' => 'required|string']);
        $submission = TaskSubmission::findOrFail($id);
        $submission->status = 2;
        $submission->admin_note = $request->admin_note;
        $submission->save();

        $task = $submission->task;
        $task->remaining_slots += 1;
        if ($task->remaining_slots > 0 && $task->status == 3) {
            $task->status = 1;
        }
        $task->save();

        return back()->with('success', 'Submission rejected.');
    }
}
