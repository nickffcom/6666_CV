<?php

use Carbon\Carbon;

const CON_HANG=1;
const HET_HANG = 0;
const IS_ADMIN = 1999;
const NAP_TIEN = 'payment';
const GIAO_DICH = 'transaction';
const LOGO_TEXT ="Web Học";
const TRU_TIEN = 'minus';
const CONG_TIEN = 'plus';
const API_MUAFB = "muafb.net";
const FACEBOOK = 1;
const GOOGLE = 2;

const FORMAT_DATA=[
    'VIA'=>'UID|Pass|KEY2FA|Mail*|PassMail*|Note*( * :Nếu có )',
    'CLONE'=>'UID|Pass|KEY2FA|Mail|PassMail|Note( * :Nếu có )',
    'BM'=>'IDBM*|Link1*|Link2*|Note*( * :Nếu có )',
];
const FORMAT_UPDATE=[
    'VIA'=>'uid|pass|key2fa|email|passmail|note',
    'CLONE'=>'uid|pass|key2fa|email|passmail|note',
    'BM'=>'idbm|linkbm1|linkbm2|note',
];
const SERVICE = [
    'BM', 'VIA', 'CLONE'
];
function DB_VIA($uid,$pass,$key2fa,$email,$passMail,$note=''){

    return $VIA = ['uid'=>$uid,'pass'=>$pass,'key2fa'=>$key2fa,'email'=>$email,'passmail'=>$passMail,'note'=>$note];

}

function DB_BM($uid,$pass,$key2fa,$email,$passMail,$note=''){

    return $BM = ['idbm'=>$uid,'linkbm1'=>$pass,'linkbm2'=>$key2fa,'note'=>$email];
}


function cURL ($url, $data = NULL, $cookie = NULL, $headers = NULL, $proxy = NULL) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    // curl_setopt($ch, CURLOPT_HEADER, true);
    if (is_null($headers) === false) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    if (is_null($data) === false) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    }
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($ch, CURLOPT_TCP_NODELAY, 1);
    if (is_null($cookie) === false) {
        if ($cookie != 'is_cookie') {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        } else {
            curl_setopt($ch, CURLOPT_COOKIE, 1);
        }
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    }
    if (is_null($proxy) === false) {
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function text_style($t) {
    $t = str_replace("\n", '<br>', $t);
    $t = preg_replace_callback('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', function ($a) {
        return '<a href="' . $a[0] . '" target="_blank">' . $a[0] . '</a>';
    }, $t);
    return $t;
}

function time_text ($t) {
    $musty = array('giây', 'phút', 'giờ', 'ngày', 'tuần', 'tháng', 'năm', 'thập kỷ');
    $format = array('60', '60', '24', '7', '4.35', '12', '10');
    $textTime = time() - $t;
    for ($i = 0; $textTime >= $format[$i] && $i < count($format) - 1; $i++) {
        $textTime /= $format[$i];   
    }
    return round($textTime) . ' ' . $musty[$i] . '  trước';
}

function time_ads($time){
    Carbon::setLocale('vi');
    $temp = Carbon::create($time);
    $now = Carbon::now();
    return $temp->diffForHumans($now);
}

?>