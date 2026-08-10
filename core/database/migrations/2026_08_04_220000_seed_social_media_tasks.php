<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('SET FOREIGN_KEY_CHECKS=0');
        DB::table('tasks')->truncate();
        DB::table('task_submissions')->truncate();
        DB::unprepared('SET FOREIGN_KEY_CHECKS=1');

        $cats = DB::table('task_categories')->pluck('id', 'slug');
        $social = $cats['social-media'] ?? 1;
        $survey = $cats['surveys'] ?? 3;

        // Famous Ethiopian accounts across platforms
        $accounts = [
            'Selam Amare', 'Hailey Beyene', 'Meraf Bahta', 'Rophnan', 'Ethiopian Airlines',
            'Kana TV', 'EBS TV', 'Fana Broadcasting', 'Ethiopian Diaspora', 'Abel Birhanu',
            'Emedi', 'Zemenu Sileshi', 'Bereket Zeleke', 'Yeyeadliba', 'Sansus',
            'Meklit Hadero', 'Gigi Jon', 'Jossy Jossy', 'Selen Kebede', 'Meron Addis',
            'Dave Lijnio', 'Kiddilight', 'Mistar Netalem', 'Solomon Assefa', 'Miki Yohannes',
            'Bethelhem Alemu', 'Yered Negussie', 'Bewketu Sewasy', 'Miki Hiwot', 'Lina Baqe',
            'Echmus', 'Yosef Tsegaye', 'River Milky', 'Semene Debre', 'Hanna Alemu',
            'Zehabesha', 'Eyerusalem Assefa', 'Roper Saleh', 'Niggatu Negussie', 'Temesgen Beyene',
            'Wendy Hiwot', 'Biruk Alemayehu', 'Eleni Tesfaye', 'Shitaye Tadesse', 'Michael Haile',
            'Wamiza K', 'Faustina At', 'Nahom Neg', 'Samrawit T', 'Kebede Fit',
            'Emma Haddis', 'Yoseph B', 'Bella T', 'Semira A', 'Kalkidan C',
            'Genet Beshare', 'Amanuel Tk', 'Dawit Getahun', 'Aida Dirar', 'Leilu Tesfaye',
            'Mimi Barno', 'Zerin C', 'Samson H', 'Tanvir A', 'Abby Wet',
        ];

        $platforms = [
            ['name' => 'follow on Instagram', 'task_type' => 'social_media', 'proof' => '["screenshot"]', 'link' => null, 'action' => 'follow'],
            ['name' => 'follow on Twitter/X', 'task_type' => 'social_media', 'proof' => '["text"]', 'link' => 'https://twitter.com', 'action' => 'follow'],
            ['name' => 'follow on Facebook', 'task_type' => 'social_media', 'proof' => '["screenshot"]', 'link' => 'https://facebook.com', 'action' => 'follow'],
            ['name' => 'follow on TikTok', 'task_type' => 'social_media', 'proof' => '["screenshot"]', 'link' => 'https://tiktok.com', 'action' => 'follow'],
            ['name' => 'subscribe on YouTube', 'task_type' => 'social_media', 'proof' => '["screenshot"]', 'link' => 'https://youtube.com', 'action' => 'subscribe'],
        ];

        $tasks = [];
        $i = 0;

        foreach ($accounts as $account) {
            foreach ($platforms as $platform) {
                $i++;
                $action = $platform['action'];
                $actionLabel = ucfirst($action);
                $tasks[] = [
                    'category_id' => $social,
                    'title' => "{$actionLabel} {$account} on " . ucwords(str_replace('_', ' ', $platform['name'])) . " Challenge",
                    'slug' => 'sm-' . $i . '-' . \Illuminate\Support\Str::slug($account),
                    'description' => "Complete the challenge: {$action} {$account} on social media and provide proof of completion.",
                    'instructions' => "1. Click the link to open the {$platform['name']} profile of {$account}\n"
                        . "2. {$actionLabel} the account {$account}\n"
                        . "3. Take a screenshot showing you have {$action}d the account\n"
                        . "4. Upload the screenshot as proof",
                    'task_type' => 'social_media',
                    'reward' => rand(100, 200),
                    'total_slots' => rand(100, 500),
                    'remaining_slots' => rand(100, 500),
                    'external_link' => $platform['link'],
                    'requirements' => null,
                    'proof_type' => $platform['proof'],
                    'start_date' => null,
                    'end_date' => Carbon::now()->addDays(rand(7, 60))->toDateTimeString(),
                    'status' => 1,
                    'task_file' => null,
                    'task_file_data' => null,
                    'task_file_type' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Add a few survey tasks to round out to 300+
        $surveyTopics = [
            'Ethiopian Coffee Consumption', 'Addis Ababa Traffic Survey', 'Digital Payment Survey',
            'Mobile Money Usage', 'E-Commerce in Ethiopia', 'Online Learning Preference',
        ];
        foreach ($surveyTopics as $topic) {
            for ($b = 1; $b <= 10; $b++) {
                $i++;
                $tasks[] = [
                    'category_id' => $survey,
                    'title' => "$topic - Survey $b",
                    'slug' => 'survey-' . $i,
                    'description' => "Participate in our $topic survey. Share your honest opinions.",
                    'instructions' => "1. Click the survey link\n2. Answer all questions\n3. Submit\n4. Paste the confirmation link as proof",
                    'task_type' => 'survey',
                    'reward' => rand(100, 200),
                    'total_slots' => rand(10, 50),
                    'remaining_slots' => rand(10, 50),
                    'external_link' => 'https://survey.earnbirr.com',
                    'requirements' => null,
                    'proof_type' => '["link"]',
                    'start_date' => null,
                    'end_date' => Carbon::now()->addDays(rand(7, 30))->toDateTimeString(),
                    'status' => 1,
                    'task_file' => null,
                    'task_file_data' => null,
                    'task_file_type' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $chunks = array_chunk($tasks, 500);
        foreach ($chunks as $chunk) {
            DB::table('tasks')->insert($chunk);
        }
    }

    public function down(): void
    {
        DB::unprepared('SET FOREIGN_KEY_CHECKS=0');
        DB::table('tasks')->truncate();
        DB::table('task_submissions')->truncate();
        DB::unprepared('SET FOREIGN_KEY_CHECKS=1');
    }
};