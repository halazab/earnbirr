<?php

use App\Models\Task;
use App\Models\TaskCategory;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $cat = fn($slug) => TaskCategory::whereSlug($slug)->first()?->id;

        $socialMedia = $cat('social-media');
        $microTasks = $cat('micro-tasks');
        $surveys = $cat('surveys');
        $freelance = $cat('freelance');

        $categories = [$socialMedia, $microTasks, $surveys, $freelance];
        $types = ['social_media', 'micro_task', 'survey', 'freelance'];
        $proofTypes = [['file','text'], ['file'], ['text'], ['file','text']];

        $titles = [
            'Follow Instagram Account', 'Like Facebook Post', 'Share YouTube Video', 'Subscribe YouTube Channel',
            'Retweet Twitter Post', 'Follow Twitter Account', 'Join Telegram Group', 'Subscribe Telegram Channel',
            'Like TikTok Video', 'Follow TikTok Account', 'Subscribe to Newsletter', 'Download Mobile App',
            'Rate App on Play Store', 'Review App on App Store', 'Install Browser Extension', 'Create Account on Website',
            'Complete Profile Setup', 'Verify Email Address', 'Connect Social Account', 'Share App with Friends',
            'Write App Review', 'Watch Video Tutorial', 'Complete Online Course', 'Join Discord Server',
            'Follow LinkedIn Page', 'Connect on LinkedIn', 'Join Facebook Group', 'Like Facebook Event',
            'Subscribe to Podcast', 'Follow Pinterest Board', 'Repost on Instagram', 'Comment on YouTube Video',
            'Like Medium Article', 'Follow Medium Publication', 'Subscribe to Substack', 'Join Reddit Community',
            'Upvote Reddit Post', 'Follow Tumblr Blog', 'Reblog Tumblr Post', 'Follow Spotify Artist',
            'Save Spotify Playlist', 'Follow SoundCloud Artist', 'Like SoundCloud Track', 'Follow Vimeo Channel',
            'Subscribe to RSS Feed', 'Follow Quora Profile', 'Answer Quora Question', 'Follow Stack Overflow',
            'Star GitHub Repository', 'Follow GitHub User', 'Fork GitHub Project', 'Contribute to Open Source',
            'Write Blog Post', 'Create YouTube Short', 'Make Instagram Reel', 'Create TikTok Content',
            'Design Social Media Post', 'Write Twitter Thread', 'Create Infographic', 'Design Banner',
            'Edit Video Content', 'Write Newsletter', 'Create Poll', 'Survey Participation',
            'Product Testing', 'Website Feedback', 'App Testing', 'Beta Testing',
            'Data Collection', 'Image Annotation', 'Audio Transcription', 'Video Subtitling',
            'Translation Task', 'Content Moderation', 'SEO Analysis', 'Keyword Research',
            'Competitor Analysis', 'Market Research', 'User Interview', 'Focus Group',
            'Online Survey', 'Phone Interview', 'In-Store Visit', 'Mystery Shopping',
            'Product Review', 'Service Review', 'Restaurant Review', 'Hotel Review',
            'Travel Blog Post', 'Food Blog Post', 'Tech Review Article', 'Book Review Post',
            'Movie Review Article', 'Music Review Post', 'Game Review Article', 'App Review Post',
            'Write Article Content', 'Create Tutorial Guide', 'Record Podcast Episode', 'Make Video Content',
            'Design Template Pack', 'Create Preset Bundle', 'Write Ebook Chapter', 'Create Online Course',
            'Data Entry Project', 'File Conversion Task', 'PDF Processing Task', 'Image Resizing Task',
            'Logo Creation Project', 'Business Card Design Task', 'Flyer Design Project', 'Poster Design Task',
            'Social Media Management Task', 'Email Marketing Campaign', 'Content Calendar Planning', 'Campaign Strategy',
            'Customer Support Ticket', 'Live Chat Support Task', 'Email Response Task', 'Ticket Resolution Task',
            'Virtual Assistant Task', 'Calendar Management Task', 'Travel Booking Research', 'Research Project',
            'Transcription Assignment', 'Caption Writing Task', 'Subtitle Creation Task', 'Voice Recording Task',
            'Translation Assignment', 'Localization Project', 'Cultural Research Task', 'Language Testing Task',
            'Quality Assurance Testing', 'Bug Reporting Task', 'Feature Testing Assignment', 'Usability Testing Task',
            'Accessibility Audit Task', 'Performance Testing Task', 'Security Review Task', 'Code Review Task',
            'Write Documentation', 'Create User Guide', 'FAQ Creation Task', 'Knowledge Base Article',
            'Onboarding Content Creation', 'Training Material Development', 'Presentation Design Task', 'Slide Deck Creation',
            'Data Visualization Project', 'Chart Creation Task', 'Dashboard Design Project', 'Report Writing Task',
            'Financial Analysis Report', 'Budget Planning Task', 'Cost Estimation Project', 'ROI Calculation Task',
            'Project Planning Document', 'Timeline Creation Task', 'Task Breakdown Analysis', 'Resource Allocation Plan',
            'Risk Assessment Report', 'Stakeholder Mapping Task', 'Communication Plan Creation', 'Change Management Plan',
            'Process Documentation', 'Workflow Design Task', 'SOP Creation Document', 'Checklist Building Task',
            'Survey Design Project', 'Questionnaire Creation Task', 'Form Building Project', 'Data Collection Plan',
            'A/B Testing Analysis', 'Split Testing Task', 'Multivariate Testing Project', 'Conversion Optimization Task',
            'Landing Page Design', 'CRO Audit Report', 'Heatmap Analysis Task', 'User Flow Mapping Project',
            'Wireframe Creation Task', 'Mockup Design Project', 'Prototype Building Task', 'UI/UX Review Report',
            'Brand Guidelines Document', 'Style Guide Creation', 'Color Palette Design', 'Typography Selection Task',
            'Icon Design Project', 'Illustration Work Task', 'Animation Creation Project', 'Motion Graphics Task',
            'Video Editing Project', 'Audio Editing Task', 'Podcast Editing Assignment', 'Music Production Task',
            'Stock Photo Curation', 'Image Search Task', 'Photo Editing Project', 'Background Removal Task',
            'Product Photography Brief', 'Flat Lay Styling Task', 'Lifestyle Photography Brief', 'Portrait Editing Task',
            'Social Media Audit Report', 'Content Strategy Document', 'Growth Hacking Plan', 'Viral Campaign Design',
            'Influencer Outreach Plan', 'Partnership Proposal Document', 'Sponsorship Pitch Deck', 'Collaboration Plan',
            'Email Campaign Design', 'Drip Sequence Creation', 'Newsletter Design Task', 'Email Template Design',
            'Landing Page Copy', 'Sales Page Copywriting', 'Ad Copy Creation', 'Social Media Captions',
            'Tagline Creation Task', 'Slogan Writing Project', 'Brand Naming Task', 'Product Naming Project',
            'Keyword Optimization Task', 'Meta Description Writing', 'Title Tag Optimization', 'Header Tags Review',
            'Internal Linking Strategy', 'External Linking Plan', 'Backlink Analysis Report', 'Competitor Backlinks Research',
            'Content Gap Analysis Report', 'Topic Research Project', 'Content Clusters Design', 'Pillar Content Creation',
            'Blog Outline Document', 'Article Structure Plan', 'Content Brief Creation', 'Writer Guidelines Document',
            'Grammar Check Assignment', 'Proofreading Task', 'Copy Editing Project', 'Fact Checking Assignment',
            'Plagiarism Check Task', 'Readability Analysis Report', 'Tone Analysis Document', 'Style Consistency Review',
            'Localization Check Task', 'Cultural Sensitivity Review', 'Inclusivity Audit', 'Accessibility Check Report',
            'Performance Audit Report', 'Speed Optimization Task', 'Image Optimization Project', 'Code Minification Task',
            'Cache Setup Configuration', 'CDN Configuration Task', 'SSL Setup Guide', 'Security Hardening Plan',
            'Backup Strategy Document', 'Disaster Recovery Plan', 'Incident Response Document', 'Business Continuity Plan',
            'Compliance Check Report', 'GDPR Audit Task', 'Privacy Policy Review', 'Terms of Service Review',
            'Cookie Policy Document', 'Data Processing Agreement', 'Consent Management Plan', 'Breach Notification Plan',
            'Financial Reporting Task', 'Tax Preparation Document', 'Audit Support Task', 'Budget Tracking Report',
            'Expense Management Plan', 'Revenue Analysis Report', 'Profit Optimization Task', 'Cost Reduction Plan',
            'Market Analysis Report', 'SWOT Analysis Document', 'PEST Analysis Report', 'Porter Five Forces Analysis',
            'Customer Segmentation Plan', 'Persona Development Task', 'Journey Mapping Project', 'Touchpoint Analysis Report',
            'NPS Survey Design', 'CSAT Survey Creation', 'CES Survey Design', 'Feedback Collection Plan',
            'Review Management Strategy', 'Reputation Management Plan', 'Crisis Communication Plan', 'PR Strategy Document',
            'Event Planning Project', 'Webinar Setup Task', 'Conference Preparation Plan', 'Workshop Design Document',
            'Training Development Plan', 'E-Learning Course Design', 'Quiz Creation Task', 'Assessment Design Project',
            'Certification Program Design', 'Mentorship Plan Document', 'Coaching Framework Plan', 'Leadership Development Plan',
            'Team Building Activity Plan', 'Culture Assessment Report', 'Engagement Survey Design', 'Retention Strategy Document',
            'Recruitment Marketing Plan', 'Employer Branding Strategy', 'Job Description Writing', 'Interview Guide Document',
            'Onboarding Program Design', 'Performance Review Template', 'Career Development Plan', 'Succession Planning Document',
            'Diversity Initiative Plan', 'Inclusion Program Design', 'Equity Assessment Report', 'Belonging Strategy Document',
            'Wellness Program Design', 'Mental Health Support Plan', 'Work-Life Balance Guide', 'Flexible Working Policy',
            'Remote Work Setup Guide', 'Home Office Design Plan', 'Productivity Tools Review', 'Time Management Guide',
            'Focus Techniques Guide', 'Deep Work Strategy', 'Pomodoro Method Implementation', 'GTD System Setup',
            'Mind Mapping Guide', 'Brainstorming Framework', 'Design Thinking Workshop', 'Lean Canvas Creation',
            'Business Model Canvas', 'Value Proposition Design', 'Revenue Model Planning', 'Go-to-Market Strategy',
            'Product Launch Plan', 'Marketing Campaign Design', 'Growth Strategy Document', 'Scale Plan Creation',
            'Exit Strategy Planning', 'Succession Plan Document', 'Legacy Building Plan', 'Impact Measurement Framework',
            'Social Impact Report', 'Environmental Initiative Plan', 'Community Program Design', 'Volunteer Coordination Plan',
            'Charity Campaign Design', 'Fundraising Event Plan', 'Donor Management System', 'Grant Writing Assignment',
            'Impact Report Writing', 'Annual Report Creation', 'Board Presentation Design', 'Stakeholder Update Document',
            'Investor Pitch Deck', 'Financial Model Creation', 'Valuation Report Writing', 'Due Diligence Checklist',
            'Term Sheet Review', 'Cap Table Management', 'Equity Split Analysis', 'Partnership Agreement Draft',
            'MOU Signing Document', 'Contract Review Task', 'Legal Compliance Check', 'IP Protection Plan',
            'Trademark Search Task', 'Patent Research Assignment', 'Copyright Check Report', 'License Agreement Review',
            'NDA Drafting Task', 'Non-Compete Agreement', 'Service Level Agreement', 'Vendor Management Plan',
            'Supplier Evaluation Report', 'Procurement Process Design', 'Inventory Management System', 'Supply Chain Analysis',
            'Logistics Planning Document', 'Warehouse Management Plan', 'Delivery Optimization Task', 'Quality Control Process',
            'Six Sigma Project', 'Lean Manufacturing Plan', 'Kaizen Event Design', 'Process Improvement Plan',
            'Automation Project Plan', 'Digital Transformation Strategy', 'AI Implementation Plan', 'Machine Learning Project',
            'Data Science Analysis', 'Predictive Analytics Model', 'Business Intelligence Report', 'Dashboard Design Project',
            'Report Automation Plan', 'KPI Tracking System', 'OKR Setting Framework', 'Strategic Planning Document',
            'Annual Planning Document', 'Quarterly Review Report', 'Monthly Check-in Template', 'Weekly Standup Guide',
            'Daily Huddle Framework', 'Retrospective Guide', 'Sprint Planning Document', 'Kanban Board Setup',
            'Scrum Master Guide', 'Product Owner Manual', 'Agile Coach Playbook', 'DevOps Setup Guide',
            'CI/CD Pipeline Setup', 'Cloud Migration Plan', 'Infrastructure Setup Guide', 'Monitoring Setup Plan',
            'Alerting System Design', 'Logging Solution Setup', 'Tracing Implementation Plan',
        ];

        $descs = [
            'Complete this social media engagement task and earn rewards.',
            'Help us grow our online presence by completing this simple task.',
            'Join our community and earn while you engage with our content.',
            'Support our brand by completing this quick engagement task.',
            'Be part of our growth story - complete this task and earn.',
            'Help us reach more people through social media engagement.',
            'Quick and easy task - engage with our content and earn.',
            'Your engagement matters - complete this task for rewards.',
            'Help build our online community and earn rewards.',
            'Simple task, real rewards - engage with our social media.',
            'Support small businesses by completing this micro task.',
            'Help us improve our products through your feedback.',
            'Share your opinion and earn rewards for your time.',
            'Your feedback helps us serve you better.',
            'Complete this survey and contribute to better services.',
            'Help shape the future of our products with your input.',
            'Freelance gig - use your skills to earn premium rewards.',
            'Creative project - showcase your talents and earn.',
            'Translation task - help us reach a wider audience.',
            'Writing task - create content and earn premium rewards.',
        ];

        $instructions = '1. Follow the link provided\n2. Complete the required action\n3. Take a screenshot as proof\n4. Submit your proof';

        $tasks = [];
        $usedSlugs = [];

        for ($i = 0; $i < 300; $i++) {
            $catIdx = $i % 4;
            $title = $titles[$i % count($titles)];
            if ($i >= count($titles)) {
                $title .= ' #' . ($i + 1);
            }
            $slug = Str::slug($title);
            if (in_array($slug, $usedSlugs)) {
                $slug .= '-' . ($i + 1);
            }
            $usedSlugs[] = $slug;

            $reward = rand(11000, 13500) / 100;
            $slots = rand(50, 200);

            $tasks[] = [
                'category_id' => $categories[$catIdx],
                'title' => $title,
                'slug' => $slug,
                'description' => $descs[$i % count($descs)],
                'instructions' => $instructions,
                'task_type' => $types[$catIdx],
                'reward' => $reward,
                'total_slots' => $slots,
                'remaining_slots' => $slots,
                'proof_type' => json_encode($proofTypes[$catIdx]),
                'end_date' => Carbon::now()->addDays(rand(14, 60)),
                'status' => 1,
            ];
        }

        foreach ($tasks as $task) {
            Task::updateOrCreate(['slug' => $task['slug']], $task);
        }
    }

    public function down(): void
    {
        Task::where('reward', '>=', 110)->where('reward', '<=', 135)->delete();
    }
};
