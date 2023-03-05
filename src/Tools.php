<?php

namespace Super;

class Tools
{
    function persianToEnglishNumber($number)
    {
        return strtr($string, [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',
            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9',
        ]);
    }

    function englishToPersianNumber($number)
    {
        return strtr($string, [
            '0' => '۰',
            '1' => '۱',
            '2' => '۲',
            '3' => '۳',
            '4' => '۴',
            '5' => '۵',
            '6' => '۶',
            '7' => '۷',
            '8' => '۸',
            '9' => '۹',
        ]);

    }

    function base64ToImage($base64_string, $output_file)
    {
        $file = fopen($output_file, "wb");
        fwrite($file, base64_decode($base64_string));
        fclose($file);

        return $output_file;
    }

    // check for exist the key in Illuminate\Support\Facades\Cache
    // if found, so say it's locked
    // if not found, so it's locked about 1 minute and say not lock
    function checkKeyRedisّIsLock($key_prefix)
    {
        // if found, so say it's locked
        if (Illuminate\Support\Facades\Cache::has($key_prefix)) {
            return true;
        }

        // if not found, so it's locked about 1 minute and say not lock
        Cache::put($key_prefix, true, 1);
        return false;
    }
    
    // remove lock
    function removeKeyRedisّIsLock($key_prefix)
    {
        Illuminate\Support\Facades\Cache::forget($key_prefix);
        return true;
    }

    function removeCountryNumberPhoneForIran($phone)
    {
        $country_code = '+98';
        $phone_no     = '+' . $phone;

        // remove +98
        $final = preg_replace('/^\+?98|\|98|\D/', '', ($phone_no));

        return '0' . $final; // output 09168187257
    }

    function set_queryStringRedis($sessionName, $operatorMeli, $value, $time)
    {
        Illuminate\Support\Facades\Cache::forget('QueryString' . $operatorMeli . $sessionName);
        return Illuminate\Support\Facades\Cache::remember('QueryString' . $operatorMeli . $sessionName, $time, function () use ($value) {
            return $value;
        });
    }

    function get_queryStringRedis($sessionName, $operatorMeli)
    {
        return Illuminate\Support\Facades\Cache::get('QueryString' . $operatorMeli . $sessionName);
    }

    function delete_queryStringRedis($sessionName, $operatorMeli)
    {
        return Illuminate\Support\Facades\Cache::forget('QueryString' . $operatorMeli . $sessionName);
    }

}
