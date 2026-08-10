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

        // Famous Ethiopian accounts with REAL verified URLs
        $accounts = [
            // Musicians
            ['name' => 'Teddy Afro', 'ig' => 'https://www.instagram.com/teddyafromuzika', 'fb' => 'https://www.facebook.com/teddyafro', 'x' => 'https://twitter.com/teddyafro', 'yt' => 'https://www.youtube.com/@teddyafro', 'tt' => null, 'tg' => null],
            ['name' => 'Yared Negu', 'ig' => 'https://www.instagram.com/yarednegu', 'fb' => 'https://www.facebook.com/YaredNeguOfficial', 'x' => 'https://twitter.com/yarednegu3', 'yt' => 'https://www.youtube.com/@YaredNegu_Official', 'tt' => 'https://www.tiktok.com/@yaredneguofficial', 'tg' => 'https://t.me/yarednegu'],
            ['name' => 'Rophnan', 'ig' => 'https://www.instagram.com/rophnan', 'fb' => 'https://www.facebook.com/RophnanOfficial', 'x' => null, 'yt' => 'https://www.youtube.com/@rophnan', 'tt' => null, 'tg' => 'https://t.me/rophnan'],
            ['name' => 'Nardos Adane', 'ig' => 'https://www.instagram.com/nardos_adane_official', 'fb' => 'https://www.facebook.com/NardosAdane', 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Mulatu Astatke', 'ig' => null, 'fb' => 'https://www.facebook.com/mulatuastatke', 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Bewketu Sewasy', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@BewketuSewasy', 'tt' => null, 'tg' => null],

            // TikTok stars (verified via search)
            ['name' => 'Yuti Nass', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@yutinass4300', 'tt' => 'https://www.tiktok.com/@yuti_nass', 'tg' => null],
            ['name' => 'Kalu Putic', 'ig' => 'https://www.instagram.com/kaluputics', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@kalu.putic', 'tg' => null],
            ['name' => 'Haymi Hager', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@haymi_hager', 'tg' => null],
            ['name' => 'Mighty Habesha', 'ig' => 'https://www.instagram.com/mightyhabesha', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@mightyhabesha', 'tg' => null],
            ['name' => 'The Ethiopian', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@theethiopian9', 'tg' => null],
            ['name' => 'Ermias Wondimu', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@ermias_wondimu', 'tg' => null],

            // TikTok stars (verified via Heepsy Ethiopia top charts, exact handles)
            ['name' => 'SAMI Papa', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@sami_papa', 'tg' => null],
            ['name' => 'Dani Royal', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@dani_royal_', 'tg' => null],
            ['name' => 'Abdi Live', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@abdi12026', 'tg' => null],
            ['name' => 'Eshetu Melese', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@comedian_eshetumelese', 'tg' => null],
            ['name' => 'Abel A. ET', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@abela.et', 'tg' => null],
            ['name' => 'Mensur', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@mensurjemal', 'tg' => null],
            ['name' => 'Medina Bargeco', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@medinatiktok.1', 'tg' => null],
            ['name' => 'Bereket Tesfaye', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@b_e_k_i_', 'tg' => null],
            ['name' => 'Fozita', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@fozita49', 'tg' => null],
            ['name' => 'Jon Daniel', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@jon_daniel', 'tg' => null],
            ['name' => 'Neba4kilo', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@neba4kilo', 'tg' => null],

            // Musicians & artists (verified via bio/profile pages)
            ['name' => 'Betty G', 'ig' => 'https://www.instagram.com/betty_g_music', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Jemberu Demeke', 'ig' => 'https://www.instagram.com/jemberu.demeke', 'fb' => null, 'x' => 'https://twitter.com/jemberudemeke', 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Hewan Gebrewold', 'ig' => 'https://www.instagram.com/hewan_gebrewold', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Zema Alem Show', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Zema_alem', 'tt' => null, 'tg' => null],
            ['name' => 'Birukti (Violin)', 'ig' => 'https://www.instagram.com/biruktiviolin', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => 'https://t.me/viobuk'],

            // Actresses (verified)
            ['name' => 'Ruth Negga', 'ig' => 'https://www.instagram.com/negga.ruth', 'fb' => 'https://www.facebook.com/RuthNegga', 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Mahder Assefa', 'ig' => 'https://www.instagram.com/mahdeassefa', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],

            // Media & cinema (verified YouTube handles)
            ['name' => 'Dara Cinema', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@daracenima', 'tt' => null, 'tg' => null],
            ['name' => 'Walta TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/c/WaltaTV', 'tt' => null, 'tg' => null],
            ['name' => 'Sheger Gebeta', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => 'https://t.me/shegergebeta'],

            // Media & TV channels
            ['name' => 'Kana TV', 'ig' => null, 'fb' => 'https://www.facebook.com/KanaTV', 'x' => null, 'yt' => 'https://www.youtube.com/@KanaTV', 'tt' => null, 'tg' => 'https://t.me/kana_tv_hd'],
            ['name' => 'EBS TV', 'ig' => null, 'fb' => 'https://www.facebook.com/EBSMedia', 'x' => null, 'yt' => 'https://www.youtube.com/@EBSTvWorldwide', 'tt' => null, 'tg' => null],
            ['name' => 'Fana Broadcasting', 'ig' => null, 'fb' => 'https://www.facebook.com/fanabroadcasting', 'x' => null, 'yt' => 'https://www.youtube.com/@fanabroadcast', 'tt' => null, 'tg' => 'https://t.me/fanatelevision'],
            ['name' => 'EBC Ethiopia', 'ig' => null, 'fb' => 'https://www.facebook.com/ebc', 'x' => null, 'yt' => 'https://www.youtube.com/@EBC', 'tt' => null, 'tg' => 'https://t.me/EBCNEWSNOW'],
            ['name' => 'Ethiopian Airlines', 'ig' => 'https://www.instagram.com/flyethiopian', 'fb' => 'https://www.facebook.com/ethiopianairlines', 'x' => 'https://twitter.com/flyethiopian', 'yt' => 'https://www.youtube.com/@EthiopianAirlines', 'tt' => null, 'tg' => null],
            ['name' => 'Arada Movies', 'ig' => null, 'fb' => 'https://www.facebook.com/AradaMovies', 'x' => null, 'yt' => 'https://www.youtube.com/@AradaMovies', 'tt' => null, 'tg' => null],
            ['name' => 'Hope Music', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@HopeMusic', 'tt' => null, 'tg' => null],
            ['name' => 'Abol TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@AbolTV', 'tt' => null, 'tg' => null],
            ['name' => 'Feriha', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Feriha', 'tt' => null, 'tg' => null],
            ['name' => 'DireTube', 'ig' => null, 'fb' => 'https://www.facebook.com/diretube', 'x' => null, 'yt' => 'https://www.youtube.com/@DireTube', 'tt' => null, 'tg' => null],
            ['name' => 'OBN Oromiyaa', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@OBNOromiyaa', 'tt' => null, 'tg' => null],
            ['name' => 'ESAT', 'ig' => null, 'fb' => 'https://www.facebook.com/ESAT', 'x' => null, 'yt' => 'https://www.youtube.com/@ESAT', 'tt' => null, 'tg' => null],
            ['name' => 'Abel Birhanu', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@AbelBirhanu', 'tt' => null, 'tg' => null],
            ['name' => 'YeneTube', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => 'https://t.me/yenetube'],
            ['name' => 'Fana Sport', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => 'https://t.me/FMCSport'],
            ['name' => 'Yegna', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Yegna', 'tt' => null, 'tg' => null],
            ['name' => '7x Production', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@7xProduction', 'tt' => null, 'tg' => null],
        ];

        $platforms = [
            ['key' => 'ig', 'label' => 'Instagram', 'proof' => '["screenshot"]', 'action' => 'Follow'],
            ['key' => 'fb', 'label' => 'Facebook', 'proof' => '["screenshot"]', 'action' => 'Like & Follow'],
            ['key' => 'x', 'label' => 'Twitter/X', 'proof' => '["text"]', 'action' => 'Follow'],
            ['key' => 'yt', 'label' => 'YouTube', 'proof' => '["screenshot"]', 'action' => 'Subscribe'],
            ['key' => 'tt', 'label' => 'TikTok', 'proof' => '["screenshot"]', 'action' => 'Follow'],
            ['key' => 'tg', 'label' => 'Telegram', 'proof' => '["screenshot"]', 'action' => 'Join'],
        ];

        $tasks = [];
        $i = 0;

        foreach ($accounts as $account) {
            foreach ($platforms as $platform) {
                $url = $account[$platform['key']] ?? null;
                if (!$url) continue;
                $i++;
                $action = $platform['action'];
                $tasks[] = [
                    'category_id' => $social,
                    'title' => "{$action} {$account['name']} on {$platform['label']}",
                    'slug' => 'sm-' . $i . '-' . \Illuminate\Support\Str::slug($account['name'] . '-' . $platform['label']),
                    'description' => "Support {$account['name']} by {$platform['action']} their {$platform['label']} profile. Show your support for this famous Ethiopian figure!",
                    'instructions' => "1. Click the link to open {$account['name']} on {$platform['label']}\n"
                        . "2. {$action} the official account of {$account['name']}\n"
                        . "3. Take a screenshot as proof\n"
                        . "4. Upload the screenshot as proof of completion",
                    'task_type' => 'social_media',
                    'reward' => rand(100, 200),
                    'total_slots' => rand(200, 800),
                    'remaining_slots' => rand(200, 800),
                    'external_link' => $url,
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