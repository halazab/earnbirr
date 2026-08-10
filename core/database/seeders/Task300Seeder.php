<?php

use App\Models\Task;
use App\Models\TaskCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class Task300Seeder extends Seeder
{
    public function run(): void
    {
        $cat = fn($slug) => TaskCategory::whereSlug($slug)->first()?->id;

        $socialMedia = $cat('social-media');
        $microTasks = $cat('micro-tasks');
        $surveys = $cat('surveys');
        $freelance = $cat('freelance');

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
            'Travel Blog', 'Food Blog', 'Tech Review', 'Book Review',
            'Movie Review', 'Music Review', 'Game Review', 'App Review',
            'Write Article', 'Create Tutorial', 'Record Podcast', 'Make Video',
            'Design Template', 'Create Preset', 'Write Ebook', 'Create Course',
            'Data Entry Work', 'File Conversion', 'PDF to Word', 'Image Resizing',
            'Logo Creation', 'Business Card Design', 'Flyer Design', 'Poster Design',
            'Social Media Management', 'Email Marketing', 'Content Calendar', 'Campaign Planning',
            'Customer Support', 'Live Chat Support', 'Email Response', 'Ticket Resolution',
            'Virtual Assistant', 'Calendar Management', 'Travel Booking', 'Research Task',
            'Transcription Work', 'Caption Writing', 'Subtitle Creation', 'Voice Recording',
            'Translation Work', 'Localization Task', 'Cultural Research', 'Language Testing',
            'Quality Assurance', 'Bug Reporting', 'Feature Testing', 'Usability Testing',
            'Accessibility Audit', 'Performance Testing', 'Security Review', 'Code Review',
            'Write Documentation', 'Create User Guide', 'FAQ Creation', 'Knowledge Base',
            'Onboarding Content', 'Training Material', 'Presentation Design', 'Slide Deck',
            'Data Visualization', 'Chart Creation', 'Dashboard Design', 'Report Writing',
            'Financial Analysis', 'Budget Planning', 'Cost Estimation', 'ROI Calculation',
            'Project Planning', 'Timeline Creation', 'Task Breakdown', 'Resource Allocation',
            'Risk Assessment', 'Stakeholder Mapping', 'Communication Plan', 'Change Management',
            'Process Documentation', 'Workflow Design', ' SOP Creation', 'Checklist Building',
            'Survey Design', 'Questionnaire Creation', 'Form Building', 'Data Collection Plan',
            'A/B Testing', 'Split Testing', 'Multivariate Testing', 'Conversion Optimization',
            'Landing Page Design', 'CRO Audit', 'Heatmap Analysis', 'User Flow Mapping',
            'Wireframe Creation', 'Mockup Design', 'Prototype Building', 'UI/UX Review',
            'Brand Guidelines', 'Style Guide', 'Color Palette', 'Typography Selection',
            'Icon Design', 'Illustration Work', 'Animation Creation', 'Motion Graphics',
            'Video Editing', 'Audio Editing', 'Podcast Editing', 'Music Production',
            'Stock Photo Curation', 'Image Search', 'Photo Editing', 'Background Removal',
            'Product Photography', 'Flat Lay Styling', 'Lifestyle Photography', 'Portrait Editing',
            'Social Media Audit', 'Content Strategy', 'Growth Hacking', 'Viral Campaign',
            'Influencer Outreach', 'Partnership Proposal', 'Sponsorship Pitch', 'Collaboration Plan',
            'Email Campaign', 'Drip Sequence', 'Newsletter Design', 'Email Template',
            'Landing Page Copy', 'Sales Page Copy', 'Ad Copy', 'Social Media Captions',
            'Tagline Creation', 'Slogan Writing', 'Brand Naming', 'Product Naming',
            'Keyword Optimization', 'Meta Description', 'Title Tag Optimization', 'Header Tags',
            'Internal Linking', 'External Linking', 'Backlink Analysis', 'Competitor Backlinks',
            'Content Gap Analysis', 'Topic Research', 'Content Clusters', 'Pillar Content',
            'Blog Outline', 'Article Structure', 'Content Brief', 'Writer Guidelines',
            'Grammar Check', 'Proofreading', 'Copy Editing', 'Fact Checking',
            'Plagiarism Check', 'Readability Analysis', 'Tone Analysis', 'Style Consistency',
            'Localization Check', 'Cultural Sensitivity', 'Inclusivity Review', 'Accessibility Check',
            'Performance Audit', 'Speed Optimization', 'Image Optimization', 'Code Minification',
            'Cache Setup', 'CDN Configuration', 'SSL Setup', 'Security Hardening',
            'Backup Strategy', 'Disaster Recovery', 'Incident Response', 'Business Continuity',
            'Compliance Check', 'GDPR Audit', 'Privacy Policy Review', 'Terms of Service',
            'Cookie Policy', 'Data Processing', 'Consent Management', 'Breach Notification',
            'Financial Reporting', 'Tax Preparation', 'Audit Support', 'Budget Tracking',
            'Expense Management', 'Revenue Analysis', 'Profit Optimization', 'Cost Reduction',
            'Market Analysis', 'SWOT Analysis', 'PEST Analysis', 'Porter Five Forces',
            'Customer Segmentation', 'Persona Development', 'Journey Mapping', 'Touchpoint Analysis',
            'NPS Survey', 'CSAT Survey', 'CES Survey', 'Feedback Collection',
            'Review Management', 'Reputation Management', 'Crisis Communication', 'PR Strategy',
            'Event Planning', 'Webinar Setup', 'Conference Preparation', 'Workshop Design',
            'Training Development', 'E-Learning Course', 'Quiz Creation', 'Assessment Design',
            'Certification Program', 'Mentorship Plan', 'Coaching Framework', 'Leadership Development',
            'Team Building', 'Culture Assessment', 'Engagement Survey', 'Retention Strategy',
            'Recruitment Marketing', 'Employer Branding', 'Job Description', 'Interview Guide',
            'Onboarding Program', 'Performance Review', 'Career Development', 'Succession Planning',
            'Diversity Initiative', 'Inclusion Program', 'Equity Assessment', 'Belonging Strategy',
            'Wellness Program', 'Mental Health Support', 'Work-Life Balance', 'Flexible Working',
            'Remote Work Setup', 'Home Office Design', 'Productivity Tools', 'Time Management',
            'Focus Techniques', 'Deep Work', 'Pomodoro Method', 'GTD System',
            'Mind Mapping', 'Brainstorming', 'Design Thinking', 'Lean Canvas',
            'Business Model', 'Value Proposition', 'Revenue Model', 'Go-to-Market',
            'Product Launch', 'Marketing Campaign', 'Growth Strategy', 'Scale Plan',
            'Exit Strategy', 'Succession Plan', 'Legacy Building', 'Impact Measurement',
            'Social Impact', 'Environmental Initiative', 'Community Program', 'Volunteer Coordination',
            'Charity Campaign', 'Fundraising Event', 'Donor Management', 'Grant Writing',
            'Impact Report', 'Annual Report', 'Board Presentation', 'Stakeholder Update',
            'Investor Pitch', 'Pitch Deck', 'Financial Model', 'Valuation Report',
            'Due Diligence', 'Term Sheet', 'Cap Table', 'Equity Split',
            'Partnership Agreement', 'MOU Signing', 'Contract Review', 'Legal Compliance',
            'IP Protection', 'Trademark Search', 'Patent Research', 'Copyright Check',
            'License Agreement', 'NDA Drafting', 'Non-Compete', 'Service Level Agreement',
            'Vendor Management', 'Supplier Evaluation', 'Procurement Process', 'Inventory Management',
            'Supply Chain', 'Logistics Planning', 'Warehouse Management', 'Delivery Optimization',
            'Quality Control', 'Six Sigma', 'Lean Manufacturing', 'Kaizen Event',
            'Process Improvement', 'Automation Project', 'Digital Transformation', 'AI Implementation',
            'Machine Learning', 'Data Science', 'Predictive Analytics', 'Business Intelligence',
            'Dashboard Creation', 'Report Automation', 'KPI Tracking', 'OKR Setting',
            'Strategic Planning', 'Annual Planning', 'Quarterly Review', 'Monthly Check-in',
            'Weekly Standup', 'Daily Huddle', 'Retrospective', 'Sprint Planning',
            'Kanban Board', 'Scrum Master', 'Product Owner', 'Agile Coach',
            'DevOps Setup', 'CI/CD Pipeline', 'Cloud Migration', 'Infrastructure Setup',
            'Monitoring Setup', 'Alerting System', 'Logging Solution', 'Tracing Implementation',
        ];

        $descriptions = [
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
            'Complete this micro task and earn instant rewards.',
            'Help us verify information and earn rewards.',
            'Data entry task - simple work, fair pay.',
            'Testing task - help us find and fix issues.',
            'Research task - gather information and earn.',
            'Design task - create visuals and earn rewards.',
            'Marketing task - help promote our brand.',
            'Customer service task - help our users.',
            'Content creation task - make engaging content.',
            'Analysis task - review and report findings.',
        ];

        $instructions = [
            '1. Follow the link provided\n2. Complete the required action\n3. Take a screenshot as proof\n4. Submit your proof',
            '1. Visit the page\n2. Complete the task\n3. Capture proof\n4. Upload your submission',
            '1. Open the link\n2. Do the required action\n3. Take screenshot\n4. Submit for review',
            '1. Click the link\n2. Complete the engagement\n3. Capture proof screenshot\n4. Upload and submit',
            '1. Go to the page\n2. Perform the task\n3. Take screenshot proof\n4. Submit your work',
        ];

        $categories = [$socialMedia, $microTasks, $surveys, $freelance];
        $types = ['social_media', 'micro_task', 'survey', 'freelance'];
        $proofTypes = [['file','text'], ['file'], ['text'], ['file','text']];

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
                'description' => $descriptions[$i % count($descriptions)],
                'instructions' => $instructions[$i % count($instructions)],
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
}
