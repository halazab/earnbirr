<?php

use App\Models\GeneralSetting;
use App\Models\Frontend;
use Illuminate\Support\Facades\Cache;

function gs($key = null)
{
    try {
        $setting = Cache::remember('GeneralSetting', 3600, function () {
            return GeneralSetting::first();
        });
        if (!$setting || !($setting instanceof GeneralSetting)) {
            $setting = GeneralSetting::first();
        }
    } catch (\Exception $e) {
        return $key ? '' : null;
    }
    if ($key) {
        return $setting?->{$key} ?? '';
    }
    return $setting;
}

function showAmount($amount, $decimal = 2, $separate = true, $exceptZeros = false)
{
    $separator = '';
    if ($separate) {
        $separator = ',';
    }
    $currency = gs('cur_text') ?? 'ETB';
    return number_format((float) $amount, $decimal, '.', $separator) . ' ' . $currency;
}

function getContent($dataKeys, $single = false, $limit = null, $orderById = false)
{
    if ($single) {
        return Frontend::where('data_keys', $dataKeys)->first();
    }
    $query = Frontend::where('data_keys', 'like', $dataKeys . '%');
    if ($limit) {
        $query->limit($limit);
    }
    if ($orderById) {
        $query->orderBy('id');
    }
    return $query->get();
}

function frontendImage($key, $image, $size = null)
{
    if ($image) {
        return asset('assets/templates/basic/images/' . $key . '/' . $image);
    }
    return asset('assets/templates/basic/images/default.png');
}

function getImage($path, $size = null, $option = false)
{
    return asset($path);
}

function getFilePath($key)
{
    return 'assets/templates/basic/images/' . $key;
}

function getFileSize($key)
{
    return '300x300';
}

function activeTemplate($isPath = false)
{
    return 'assets/templates/basic/';
}

function loadExtension($key)
{
    return '';
}

function showDateTime($date, $format = 'd M, Y h:i A')
{
    if (!$date) return '';
    return \Carbon\Carbon::parse($date)->format($format);
}

function diffForHumans($date)
{
    if (!$date) return '';
    return \Carbon\Carbon::parse($date)->diffForHumans();
}

function getPaginate($perPage = 20)
{
    return $perPage;
}

function inputTitle($text)
{
    return ucfirst(str_replace('_', ' ', $text));
}

function strLimit($text, $limit = 40)
{
    return \Illuminate\Support\Str::limit($text, $limit);
}

function uploadFile($file, $uploadableType = null, $uploadableId = null)
{
    $data = base64_encode(file_get_contents($file->getRealPath()));
    $upload = \App\Models\FileUpload::create([
        'name' => $file->getClientOriginalName(),
        'type' => $file->getMimeType(),
        'data' => $data,
        'uploadable_type' => $uploadableType,
        'uploadable_id' => $uploadableId,
    ]);
    return $upload->id;
}

function uploadFileUrl($fileId)
{
    if (!$fileId) return null;
    return '/uploads/' . $fileId;
}

function sendTelegramMessage($message, $photoData = null, $photoType = null)
{
    $botToken = gs('telegram_bot_token');
    $chatId = gs('telegram_chat_id');

    if (!$botToken || !$chatId) {
        return false;
    }

    $baseUrl = "https://api.telegram.org/bot{$botToken}";

    try {
        if ($photoData && $photoType) {
            $tmpFile = tempnam(sys_get_temp_dir(), 'tg_');
            file_put_contents($tmpFile, base64_decode($photoData));

            $ch = curl_init("{$baseUrl}/sendPhoto");
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'chat_id' => $chatId,
                    'caption' => $message,
                    'parse_mode' => 'HTML',
                    'photo' => new CURLFile($tmpFile, $photoType, 'photo.jpg'),
                ],
                CURLOPT_RETURNTRANSFER => true,
            ]);
            $result = curl_exec($ch);
            curl_close($ch);
            @unlink($tmpFile);
            return $result;
        }

        $ch = curl_init("{$baseUrl}/sendMessage");
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]),
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    } catch (\Exception $e) {
        return false;
    }
}

function notify($user, $type, $shortCodes = [], $sendVia = null)
{
    return true;
}

class Status
{
    const ENABLE = 1;
    const DISABLE = 0;
    const APPROVED = 1;
    const PENDING = 0;
    const REJECTED = 2;
    const KYC_UNVERIFIED = 0;
    const KYC_PENDING = 2;
    const KYC_VERIFIED = 1;
    const USER_ACTIVE = 1;
    const USER_BANNED = 0;
    const PAYMENT_PENDING = 0;
    const PAYMENT_SUCCESS = 1;
    const PAYMENT_REJECTED = 2;
    const TASK_PENDING = 0;
    const TASK_APPROVED = 1;
    const TASK_REJECTED = 2;
    const TASK_COMPLETED = 3;
    const WITHDRAWAL_PENDING = 0;
    const WITHDRAWAL_APPROVED = 1;
    const WITHDRAWAL_REJECTED = 2;
    const TICKET_OPEN = 0;
    const TICKET_ANSWERED = 1;
    const TICKET_REPLIED = 2;
    const TICKET_CLOSED = 3;
    const SUBMISSION_PENDING = 0;
    const SUBMISSION_APPROVED = 1;
    const SUBMISSION_REJECTED = 2;
}
