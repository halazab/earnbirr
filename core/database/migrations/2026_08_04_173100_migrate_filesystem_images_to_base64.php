<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        // Convert task files to base64
        $tasks = DB::table('tasks')->whereNotNull('task_file')->get();
        foreach ($tasks as $task) {
            $path = storage_path('app/public/' . $task->task_file);
            if (file_exists($path)) {
                $mime = mime_content_type($path);
                $data = base64_encode(file_get_contents($path));
                DB::table('tasks')->where('id', $task->id)->update([
                    'task_file_data' => $data,
                    'task_file_type' => $mime,
                ]);
            }
        }

        // Convert deposit method images to base64
        $methods = DB::table('deposit_methods')->whereNotNull('image')->get();
        foreach ($methods as $method) {
            $path = storage_path('app/public/' . $method->image);
            if (file_exists($path)) {
                $mime = mime_content_type($path);
                $data = base64_encode(file_get_contents($path));
                DB::table('deposit_methods')->where('id', $method->id)->update([
                    'image_data' => $data,
                    'image_type' => $mime,
                ]);
            }
        }

        // Convert KYC documents to base64
        $users = DB::table('users')->whereNotNull('kyc_info')->get();
        foreach ($users as $user) {
            $kyc = json_decode($user->kyc_info, true);
            if (!$kyc) continue;

            $updates = [];

            if (!empty($kyc['id_front'])) {
                $path = storage_path('app/public/' . $kyc['id_front']);
                if (file_exists($path)) {
                    $mime = mime_content_type($path);
                    $updates['kyc_id_front_data'] = base64_encode(file_get_contents($path));
                    $updates['kyc_id_front_type'] = $mime;
                }
            }

            if (!empty($kyc['id_back'])) {
                $path = storage_path('app/public/' . $kyc['id_back']);
                if (file_exists($path)) {
                    $mime = mime_content_type($path);
                    $updates['kyc_id_back_data'] = base64_encode(file_get_contents($path));
                    $updates['kyc_id_back_type'] = $mime;
                }
            }

            if (!empty($updates)) {
                DB::table('users')->where('id', $user->id)->update($updates);
            }
        }
    }

    public function down(): void
    {
        DB::table('tasks')->whereNotNull('task_file')->update([
            'task_file_data' => null,
            'task_file_type' => null,
        ]);

        DB::table('deposit_methods')->whereNotNull('image')->update([
            'image_data' => null,
            'image_type' => null,
        ]);

        DB::table('users')->whereNotNull('kyc_info')->update([
            'kyc_id_front_data' => null,
            'kyc_id_front_type' => null,
            'kyc_id_back_data' => null,
            'kyc_id_back_type' => null,
        ]);
    }
};
