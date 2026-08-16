<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $cats = DB::table('task_categories')->pluck('id', 'slug');
        $social = $cats['social-media'] ?? 1;

        $accounts = [
            // Musicians
            ['name' => 'Teddy Afro', 'ig' => 'https://www.instagram.com/teddyafromuzika', 'fb' => 'https://www.facebook.com/teddyafro', 'x' => 'https://twitter.com/teddyafro', 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Rophnan', 'ig' => null, 'fb' => 'https://www.facebook.com/RophnanOfficial', 'x' => null, 'yt' => 'https://www.youtube.com/@rophnan', 'tt' => null, 'tg' => null],
            ['name' => 'Yared Negu', 'ig' => null, 'fb' => 'https://www.facebook.com/YaredNeguOfficial', 'x' => 'https://twitter.com/yarednegu3', 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Betty G', 'ig' => 'https://www.instagram.com/betty_g_music', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Jemberu Demeke', 'ig' => 'https://www.instagram.com/jemberu.demeke', 'fb' => null, 'x' => 'https://twitter.com/jemberudemeke', 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Hewan Gebrewold', 'ig' => 'https://www.instagram.com/hewan_gebrewold', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Dawit Tsige', 'ig' => 'https://www.instagram.com/dawit_tsige', 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@DawitTsige', 'tt' => null, 'tg' => null],
            ['name' => 'Zema Alem Show', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Zema_alem', 'tt' => null, 'tg' => null],
            ['name' => 'Mameye Music', 'ig' => 'https://www.instagram.com/mameyemusic', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@mameyemusic', 'tg' => null],
            ['name' => 'Feven Music', 'ig' => 'https://www.instagram.com/feven_music', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@feven_music', 'tg' => null],
            ['name' => 'Sebhat Tesfaye', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@SebhatTesfaye', 'tt' => 'https://www.tiktok.com/@sebhat_tesfaye', 'tg' => null],
            ['name' => 'Rediet Dream', 'ig' => 'https://www.instagram.com/rediet_dream', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@rediet_dream', 'tg' => null],
            ['name' => 'Teleber Drama', 'ig' => 'https://www.instagram.com/teleberdrama', 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Teleber', 'tt' => 'https://www.tiktok.com/@teleberdrama', 'tg' => null],
            ['name' => 'Kassy Perez', 'ig' => 'https://www.instagram.com/kassy_perez', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@kassy_perez', 'tg' => null],
            ['name' => 'Micky Williams', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@MickyWilliams', 'tt' => 'https://www.tiktok.com/@mickywilliams', 'tg' => null],
            ['name' => 'Behailu Sirak', 'ig' => 'https://www.instagram.com/behailu_sirak', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Ezedin Berhanu', 'ig' => 'https://www.instagram.com/ezedin_berhanu', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@ezedin_berhanu', 'tg' => null],
            ['name' => 'Meron Admasu', 'ig' => 'https://www.instagram.com/meron_admasu', 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@meronadmasu', 'tt' => null, 'tg' => null],

            // TikTok stars
            ['name' => 'Yuti Nass', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@yuti_nass', 'tg' => null],
            ['name' => 'Kalu Putic', 'ig' => 'https://www.instagram.com/kaluputics', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@kalu.putic', 'tg' => null],
            ['name' => 'Haymi Hager', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@haymi_hager', 'tg' => null],
            ['name' => 'Mighty Habesha', 'ig' => 'https://www.instagram.com/mightyhabesha', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@mightyhabesha', 'tg' => null],
            ['name' => 'The Ethiopian', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@theethiopian9', 'tg' => null],
            ['name' => 'Ermias Wondimu', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@ermias_wondimu', 'tg' => null],
            ['name' => 'SAMI Papa', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@sami_papa', 'tg' => null],
            ['name' => 'Dani Royal', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@dani_royal_', 'tg' => null],
            ['name' => 'Abdi Live', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@abdi12026', 'tg' => null],
            ['name' => 'Eshetu Melese', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Eshetu_Melese', 'tt' => 'https://www.tiktok.com/@comedian_eshetumelese', 'tg' => null],
            ['name' => 'Abel A. ET', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@abela.et', 'tg' => null],
            ['name' => 'Mensur Jemal', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@mensurjemal', 'tg' => null],
            ['name' => 'Medina Bargeco', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@medinatiktok.1', 'tg' => null],
            ['name' => 'Bereket Tesfaye', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@b_e_k_i_', 'tg' => null],
            ['name' => 'Fozita', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@fozita49', 'tg' => null],
            ['name' => 'Jon Daniel', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@jon_daniel', 'tg' => null],
            ['name' => 'Neba4kilo', 'ig' => 'https://www.instagram.com/neba4kilo', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@neba4kilo', 'tg' => null],
            ['name' => 'Desalegn Reed', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@desalegnreed', 'tg' => null],
            ['name' => 'Selamawit', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@selamawit', 'tg' => null],
            ['name' => 'The Comedian', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@the_comedian', 'tg' => null],
            ['name' => 'Simegn Show', 'ig' => 'https://www.instagram.com/simegnshow', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@simegnshow', 'tg' => null],
            ['name' => 'Adugna Culture', 'ig' => 'https://www.instagram.com/adugna_culture', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => 'https://www.tiktok.com/@adugnaculture', 'tg' => null],
            ['name' => 'Habesha Style', 'ig' => 'https://www.instagram.com/habesha_style', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],

            // Athletes
            ['name' => 'Haile Gebrselassie', 'ig' => 'https://www.instagram.com/hailegebrselassie', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Kenenisa Bekele', 'ig' => 'https://www.instagram.com/kenenisa_bekele', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Almaz Ayana', 'ig' => 'https://www.instagram.com/almazayana', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Biniam Girmay', 'ig' => 'https://www.instagram.com/biniam_girmay_', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'EthioSports', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@EthioSports', 'tt' => null, 'tg' => null],

            // Actresses
            ['name' => 'Ruth Negga', 'ig' => 'https://www.instagram.com/negga.ruth', 'fb' => 'https://www.facebook.com/RuthNegga', 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Mahder Assefa', 'ig' => 'https://www.instagram.com/mahdeassefa', 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],

            // Media & TV channels
            ['name' => 'EBS TV', 'ig' => null, 'fb' => 'https://www.facebook.com/EBSMedia', 'x' => null, 'yt' => 'https://www.youtube.com/@EBSTvWorldwide', 'tt' => null, 'tg' => null],
            ['name' => 'EBS Drama', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@EbsDrama', 'tt' => null, 'tg' => null],
            ['name' => 'Kana TV', 'ig' => null, 'fb' => 'https://www.facebook.com/KanaTV', 'x' => null, 'yt' => null, 'tt' => null, 'tg' => null],
            ['name' => 'Kana Drama', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@KanaDrama', 'tt' => null, 'tg' => null],
            ['name' => 'EBC Ethiopia', 'ig' => null, 'fb' => 'https://www.facebook.com/ebc', 'x' => null, 'yt' => 'https://www.youtube.com/@ETV', 'tt' => null, 'tg' => null],
            ['name' => 'ETV Online', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@ETVOnline', 'tt' => null, 'tg' => null],
            ['name' => 'Nahoo TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@NahooTV', 'tt' => null, 'tg' => null],
            ['name' => 'Amhara TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@AmharaTV', 'tt' => null, 'tg' => null],
            ['name' => 'Lakeview TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@LakeviewTV', 'tt' => null, 'tg' => null],
            ['name' => 'Dash TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@dashtv', 'tt' => null, 'tg' => null],
            ['name' => 'Dani Tube', 'ig' => 'https://www.instagram.com/danitubetv', 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@DaniTube', 'tt' => null, 'tg' => null],
            ['name' => 'Ililta TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@ililta', 'tt' => null, 'tg' => null],
            ['name' => 'Zami Media', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@ZamiMedia', 'tt' => null, 'tg' => null],
            ['name' => 'Shege Media', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@ShegeMedia', 'tt' => null, 'tg' => null],
            ['name' => 'Einstein TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@EinsteinTV', 'tt' => null, 'tg' => null],
            ['name' => 'Daily Ethiopia', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@DailyEthiopia', 'tt' => null, 'tg' => null],
            ['name' => 'ENA Television', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@ENATelevision', 'tt' => null, 'tg' => null],
            ['name' => 'Walta TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/c/WaltaTV', 'tt' => null, 'tg' => null],
            ['name' => 'EFTV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@EFTV', 'tt' => null, 'tg' => null],
            ['name' => 'EthioNews', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@EthioNews', 'tt' => null, 'tg' => null],
            ['name' => 'Arada Movies', 'ig' => null, 'fb' => 'https://www.facebook.com/AradaMovies', 'x' => null, 'yt' => 'https://www.youtube.com/@AradaMovies', 'tt' => null, 'tg' => null],
            ['name' => 'Dara Cinema', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@daracenima', 'tt' => null, 'tg' => null],
            ['name' => 'Addis Drama', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Addis_Drama', 'tt' => null, 'tg' => null],
            ['name' => 'Habesha Movies', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@habesha_movies', 'tt' => null, 'tg' => null],
            ['name' => 'Ethio Cinema', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Ethio_Cinema', 'tt' => null, 'tg' => null],
            ['name' => 'Kino Drama', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@KinoDrama', 'tt' => null, 'tg' => null],
            ['name' => 'Bari Show', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@BariShow', 'tt' => null, 'tg' => null],
            ['name' => 'Kenan Show', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@KenanShow', 'tt' => null, 'tg' => null],
            ['name' => 'Agar Videos', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@AgarVideos', 'tt' => null, 'tg' => null],
            ['name' => 'Peace Film', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Peacefilm', 'tt' => null, 'tg' => null],
            ['name' => 'EthioKid', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@EthioKid', 'tt' => null, 'tg' => null],
            ['name' => 'HabeshaTube', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@habeshatube', 'tt' => null, 'tg' => null],
            ['name' => 'EthioTube', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@EthioTube', 'tt' => null, 'tg' => null],
            ['name' => 'EthioComedy', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@EthioComedy', 'tt' => null, 'tg' => null],
            ['name' => 'EthioMusic', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@EthioMusic', 'tt' => null, 'tg' => null],
            ['name' => 'Addis Music', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@addis_music', 'tt' => null, 'tg' => null],
            ['name' => 'Zema TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@ZemaTV', 'tt' => null, 'tg' => null],
            ['name' => 'DireTube', 'ig' => null, 'fb' => 'https://www.facebook.com/diretube', 'x' => null, 'yt' => 'https://www.youtube.com/@DireTube', 'tt' => null, 'tg' => null],
            ['name' => 'ESAT', 'ig' => null, 'fb' => 'https://www.facebook.com/ESAT', 'x' => null, 'yt' => 'https://www.youtube.com/@ESAT', 'tt' => null, 'tg' => null],
            ['name' => 'OBN Oromiyaa', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@OBNOromiyaa', 'tt' => null, 'tg' => null],
            ['name' => 'Abol TV', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@AbolTV', 'tt' => null, 'tg' => null],
            ['name' => 'Yegna', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@Yegna', 'tt' => null, 'tg' => null],
            ['name' => '7x Production', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@7xProduction', 'tt' => null, 'tg' => null],
            ['name' => 'Abel Birhanu', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@AbelBirhanu', 'tt' => null, 'tg' => null],
            ['name' => 'Garage Entertainment', 'ig' => 'https://www.instagram.com/garageentertainment', 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@GarageEntertainment', 'tt' => null, 'tg' => null],

            // Brands
            ['name' => 'Ethiopian Airlines', 'ig' => 'https://www.instagram.com/ethiopianairlines', 'fb' => 'https://www.facebook.com/ethiopianairlines', 'x' => 'https://twitter.com/flyethiopian', 'yt' => null, 'tt' => null, 'tg' => null],

            // Telegram channels
            ['name' => 'Sheger Gebeta', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => 'https://t.me/shegergebeta'],
            ['name' => 'Zeba Games', 'ig' => 'https://www.instagram.com/zebagames', 'fb' => null, 'x' => null, 'yt' => 'https://www.youtube.com/@ZebaGames', 'tt' => null, 'tg' => 'https://t.me/zebagames'],
            ['name' => 'YeneTube', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => 'https://t.me/yenetube'],
            ['name' => 'Fana Sport', 'ig' => null, 'fb' => null, 'x' => null, 'yt' => null, 'tt' => null, 'tg' => 'https://t.me/FMCSport'],
            ['name' => 'Fana Broadcasting', 'ig' => null, 'fb' => 'https://www.facebook.com/fanabroadcasting', 'x' => null, 'yt' => null, 'tt' => null, 'tg' => 'https://t.me/fanatelevision'],
        ];

        $actions = [
            'ig' => [
                ['action' => 'Follow', 'proof' => '["screenshot"]', 'title' => 'Follow {name} on Instagram', 'inst' => "1. Click the link to open {name} on Instagram\n2. Follow the official account of {name}\n3. Take a screenshot as proof\n4. Upload the screenshot as proof of completion"],
                ['action' => 'Like & Comment', 'proof' => '["screenshot"]', 'title' => 'Like & Comment on {name}\'s Instagram', 'inst' => "1. Click the link to open {name} on Instagram\n2. Like their latest post and leave a nice comment\n3. Take a screenshot as proof\n4. Upload the screenshot as proof of completion"],
            ],
            'fb' => [
                ['action' => 'Like & Follow', 'proof' => '["screenshot"]', 'title' => 'Like & Follow {name} on Facebook', 'inst' => "1. Click the link to open {name} on Facebook\n2. Like and follow the official page of {name}\n3. Take a screenshot as proof\n4. Upload the screenshot as proof of completion"],
                ['action' => 'Share', 'proof' => '["text"]', 'title' => 'Share {name}\'s Facebook Page', 'inst' => "1. Click the link to open {name} on Facebook\n2. Share their page with your friends\n3. Copy the share link as proof\n4. Paste the link as proof of completion"],
            ],
            'x' => [
                ['action' => 'Follow', 'proof' => '["text"]', 'title' => 'Follow {name} on Twitter/X', 'inst' => "1. Click the link to open {name} on Twitter/X\n2. Follow the official account of {name}\n3. Copy your profile link as proof\n4. Paste the link as proof of completion"],
                ['action' => 'Retweet', 'proof' => '["text"]', 'title' => 'Retweet {name}\'s Latest Post', 'inst' => "1. Click the link to open {name} on Twitter/X\n2. Retweet their latest post\n3. Copy the post link as proof\n4. Paste the link as proof of completion"],
            ],
            'yt' => [
                ['action' => 'Subscribe', 'proof' => '["screenshot"]', 'title' => 'Subscribe to {name} on YouTube', 'inst' => "1. Click the link to open {name} on YouTube\n2. Subscribe to the official channel of {name}\n3. Take a screenshot as proof\n4. Upload the screenshot as proof of completion"],
                ['action' => 'Watch & Like', 'proof' => '["screenshot"]', 'title' => 'Watch & Like {name}\'s Video on YouTube', 'inst' => "1. Click the link to open {name} on YouTube\n2. Watch one of their videos and like it\n3. Take a screenshot as proof\n4. Upload the screenshot as proof of completion"],
            ],
            'tt' => [
                ['action' => 'Follow', 'proof' => '["screenshot"]', 'title' => 'Follow {name} on TikTok', 'inst' => "1. Click the link to open {name} on TikTok\n2. Follow the official account of {name}\n3. Take a screenshot as proof\n4. Upload the screenshot as proof of completion"],
                ['action' => 'Like', 'proof' => '["screenshot"]', 'title' => 'Like {name}\'s Video on TikTok', 'inst' => "1. Click the link to open {name} on TikTok\n2. Watch their video and like it\n3. Take a screenshot as proof\n4. Upload the screenshot as proof of completion"],
            ],
            'tg' => [
                ['action' => 'Join', 'proof' => '["screenshot"]', 'title' => 'Join {name} on Telegram', 'inst' => "1. Click the link to open {name} on Telegram\n2. Join the official channel of {name}\n3. Take a screenshot as proof\n4. Upload the screenshot as proof of completion"],
                ['action' => 'React', 'proof' => '["screenshot"]', 'title' => 'React to {name}\'s Telegram Channel', 'inst' => "1. Click the link to open {name} on Telegram\n2. React to a post in their channel\n3. Take a screenshot as proof\n4. Upload the screenshot as proof of completion"],
            ],
        ];

        $platformLabels = [
            'ig' => 'Instagram', 'fb' => 'Facebook', 'x' => 'Twitter/X',
            'yt' => 'YouTube', 'tt' => 'TikTok', 'tg' => 'Telegram',
        ];

        $tasks = [];
        $i = 0;
        $now = now();

        foreach ($accounts as $account) {
            foreach (['ig', 'fb', 'x', 'yt', 'tt', 'tg'] as $pk) {
                $url = $account[$pk] ?? null;
                if (!$url) continue;
                $label = $platformLabels[$pk];
                foreach ($actions[$pk] as $act) {
                    $i++;
                    $title = str_replace('{name}', $account['name'], $act['title']);
                    $inst = str_replace('{name}', $account['name'], $act['inst']);
                    $tasks[] = [
                        'category_id' => $social,
                        'title' => $title,
                        'slug' => 'sm-' . $i . '-' . Str::slug($account['name'] . '-' . $label . '-' . $act['action']),
                        'description' => "Support {$account['name']} on {$label}. {$act['action']} their official profile and help this famous Ethiopian figure grow!",
                        'instructions' => $inst,
                        'task_type' => 'social_media',
                        'reward' => rand(30, 50),
                        'total_slots' => rand(200, 800),
                        'remaining_slots' => rand(200, 800),
                        'external_link' => $url,
                        'requirements' => null,
                        'proof_type' => $act['proof'],
                        'start_date' => null,
                        'end_date' => Carbon::now()->addDays(rand(7, 60))->toDateTimeString(),
                        'status' => 1,
                        'task_file' => null,
                        'task_file_data' => null,
                        'task_file_type' => null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        foreach (array_chunk($tasks, 500) as $chunk) {
            foreach ($chunk as $k => $row) {
                if (DB::table('tasks')->where('slug', $row['slug'])->exists()) {
                    unset($chunk[$k]);
                }
            }
            if ($chunk) {
                DB::table('tasks')->insert(array_values($chunk));
            }
        }
    }

    public function down(): void
    {
        DB::table('tasks')->where('task_type', 'social_media')->where('slug', 'like', 'sm-%')->delete();
    }
};
