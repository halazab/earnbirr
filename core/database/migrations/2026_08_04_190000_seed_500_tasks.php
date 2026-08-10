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
        $micro = $cats['micro-tasks'] ?? 2;
        $survey = $cats['surveys'] ?? 3;
        $freelance = $cats['freelance'] ?? 4;

        $tasks = [];
        $i = 0;

        // === SOCIAL MEDIA: 170 tasks ===
        $fbNames = [
            'Ethiopian Tech Hub','Addis Digital','Ethio Crypto Community','Ethiopian Entrepreneurs',
            'Addis Ababa Events','Ethiopian Foodies','Ethio Music Lovers','Ethiopian Travel Guide',
            'Addis Business Network','Ethiopian Developers','Ethio Fitness Club','Ethiopian Fashion Hub',
            'Addis Art Gallery','Ethiopian Photography','Ethio Gaming Zone','Ethiopian Book Club',
            'Addis Food Blog','Ethiopian Health Tips','Ethio Startup Hub','Ethiopian Education Network',
        ];
        foreach ($fbNames as $page) {
            $i++;
            $tasks[] = $this->task($social, "Like {$page} on Facebook", 'fb-like-'.$i,
                "Visit {$page} Facebook page and like it. Take a screenshot as proof.",
                "1. Click the link\n2. Like the Facebook page\n3. Take a screenshot\n4. Upload as proof",
                'social_media', '["screenshot"]', 'https://facebook.com');
        }
        foreach (range(1,20) as $n) {
            $i++;
            $tasks[] = $this->task($social, "Follow on Twitter/X - Account #{$n}", 'tw-follow-'.$i,
                "Follow our Twitter account and submit your username as proof.",
                "1. Click the link\n2. Follow the account\n3. Submit your Twitter username",
                'social_media', '["text"]', 'https://twitter.com');
        }
        foreach (range(1,30) as $n) {
            $i++;
            $tasks[] = $this->task($social, "Follow on Instagram - Account #{$n}", 'ig-follow-'.$i,
                "Follow our Instagram account and screenshot your profile.",
                "1. Open Instagram\n2. Follow the account\n3. Screenshot your profile\n4. Upload as proof",
                'social_media', '["screenshot"]', null);
        }
        foreach (range(1,20) as $n) {
            $i++;
            $tasks[] = $this->task($social, "Subscribe to YouTube Channel #{$n}", 'yt-sub-'.$i,
                "Subscribe to our YouTube channel and like the latest video.",
                "1. Click the YouTube link\n2. Subscribe\n3. Like the latest video\n4. Screenshot subscription",
                'social_media', '["screenshot"]', 'https://youtube.com');
        }
        foreach (range(1,30) as $n) {
            $i++;
            $tasks[] = $this->task($social, "Follow on TikTok - Creator #{$n}", 'tt-follow-'.$i,
                "Follow our TikTok creator and like 3 videos.",
                "1. Open TikTok\n2. Follow the creator\n3. Like 3 videos\n4. Screenshot and upload",
                'social_media', '["screenshot"]', null);
        }
        foreach (range(1,20) as $n) {
            $i++;
            $tasks[] = $this->task($social, "Join Telegram Group #{$n}", 'tg-join-'.$i,
                "Join our Telegram group and send a greeting message.",
                "1. Click the Telegram link\n2. Join the group\n3. Send a greeting\n4. Screenshot and upload",
                'social_media', '["screenshot"]', 'https://t.me');
        }
        foreach (range(1,10) as $n) {
            $i++;
            $tasks[] = $this->task($social, "Follow on LinkedIn - Page #{$n}", 'li-follow-'.$i,
                "Follow our LinkedIn page and endorse a skill.",
                "1. Open LinkedIn\n2. Follow the page\n3. Endorse a skill\n4. Screenshot and upload",
                'social_media', '["screenshot"]', null);
        }
        foreach (range(1,20) as $n) {
            $i++;
            $tasks[] = $this->task($social, "Download App & Leave Review #{$n}", 'app-review-'.$i,
                "Download an app, use it for 5 minutes, then leave a review on the app store.",
                "1. Download the app\n2. Use it for 5 minutes\n3. Leave a review\n4. Screenshot the review and upload",
                'social_media', '["screenshot"]', null);
        }

        // === MICRO TASKS: 140 tasks ===
        $microTypes = [
            ['Data Entry - Product Listings','Enter product names, descriptions and prices from images.'],
            ['Image Tagging - Product Photos','Tag product images with relevant keywords.'],
            ['Website Link Verification','Check URLs and verify they load correctly.'],
            ['Email Address Collection','Collect email addresses from business websites.'],
            ['Business Name Research','Research business names, addresses from Google Maps.'],
            ['Product Description Writing','Write short descriptions for 20 products.'],
            ['Social Media Profile Collection','Collect social media profile URLs for businesses.'],
            ['Survey Form Filling','Fill out a detailed survey form.'],
            ['Photo Classification','Classify 50 photos into categories.'],
            ['App Testing - Screenshot Collection','Navigate through app screens and take screenshots.'],
            ['Price Comparison Research','Compare prices across 3 websites.'],
            ['Google Maps Business Review','Leave genuine reviews for local businesses.'],
            ['Content Moderation Check','Review posts and flag inappropriate content.'],
            ['File Format Conversion','Convert documents from Word to PDF.'],
            ['Data Cleaning - Remove Duplicates','Remove duplicates from a spreadsheet.'],
            ['Transcription - Short Audio','Transcribe a 5-minute audio clip.'],
            ['Translation - Amharic to English','Translate 500 words accurately.'],
            ['Form Data Entry','Enter data from handwritten forms.'],
            ['Customer Review Collection','Collect reviews from Google Maps.'],
            ['Social Media Post Scheduling','Schedule 10 posts across platforms.'],
        ];
        foreach ($microTypes as $mt) {
            for ($b = 1; $b <= 7; $b++) {
                $i++;
                $tasks[] = $this->task($micro, $mt[0]." - Batch $b", 'micro-'.$i,
                    $mt[1], "1. Read instructions\n2. Complete the task\n3. Submit your work",
                    'micro_task', '["file","text"]', null);
            }
        }

        // === SURVEYS: 90 tasks ===
        $surveyTopics = [
            'Mobile Phone Usage Habits','Online Shopping Preferences','Social Media Usage',
            'Transportation Habits','Food Delivery Feedback','Banking App Experience',
            'Telecom Quality Survey','Education Technology','Healthcare Access',
            'Entertainment Preferences','Grocery Shopping Habits','Fitness App Usage',
            'Travel Preferences','Internet Quality Survey','Freelancing Experience',
            'Digital Payment Adoption','Career Development','Language Learning Feedback',
            'Gaming Habits','Environmental Awareness','Home Improvement Preferences',
            'Fashion Preferences','Movie Preferences','Podcast Habits',
            'Book Reading Preferences','Cooking Habits','Parenting Survey',
            'Financial Planning','Customer Service Experience','Remote Work Survey',
        ];
        foreach ($surveyTopics as $topic) {
            for ($b = 1; $b <= 3; $b++) {
                $i++;
                $tasks[] = $this->task($survey, "$topic - Survey $b", 'survey-'.$i,
                    "Participate in our $topic survey. Share your honest opinions.",
                    "1. Click the survey link\n2. Answer all questions\n3. Submit\n4. Paste the confirmation link as proof",
                    'survey', '["link"]', 'https://survey.earnbirr.com');
            }
        }

        // === FREELANCE: 105 tasks ===
        $freelanceTypes = [
            ['Logo Design - Small Business','Design a professional logo. Requirements in instructions.'],
            ['Content Writing - Blog Posts','Write a 500-word blog post on earning money online.'],
            ['Amharic to English Translation','Translate 1000 words accurately.'],
            ['Video Editing - Short Reel','Edit a 60-second promotional video.'],
            ['Voice Over - Amharic','Record a 2-minute voiceover in Amharic.'],
            ['Web Design - Landing Page','Design a responsive landing page.'],
            ['Social Media Banner Design','Create 5 banners for social media.'],
            ['Flyer Design - Event Promotion','Design a promotional flyer for an event.'],
            ['Podcast Editing - 30 Min Episode','Edit a 30-minute podcast episode.'],
            ['Data Analysis - Survey Results','Analyze survey results and create a report.'],
            ['UI/UX Design - Mobile App','Design mockups for a mobile app.'],
            ['Resume Writing - Professional','Write a professional resume.'],
            ['Product Photography Editing','Edit 20 product photos.'],
            ['Email Newsletter Design','Design an email newsletter template.'],
            ['Business Plan Writing','Write a 3-page business plan.'],
        ];
        foreach ($freelanceTypes as $ft) {
            for ($b = 1; $b <= 7; $b++) {
                $i++;
                $tasks[] = $this->task($freelance, $ft[0]." - Project $b", 'freelance-'.$i,
                    $ft[1], "1. Read the brief carefully\n2. Complete the work\n3. Submit your deliverable",
                    'freelance', '["file"]', null);
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

    private function task(int $catId, string $title, string $slug, string $desc, string $instructions, string $type, string $proofType, ?string $link): array
    {
        return [
            'category_id' => $catId,
            'title' => $title,
            'slug' => $slug,
            'description' => $desc,
            'instructions' => $instructions,
            'task_type' => $type,
            'reward' => rand(100, 200),
            'total_slots' => rand(20, 200),
            'remaining_slots' => rand(20, 200),
            'external_link' => $link,
            'requirements' => null,
            'proof_type' => $proofType,
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
};
