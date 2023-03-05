<?php

namespace Super;

class Tools
{
    public function persianToEnglishNumber($number)
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

    public function englishToPersianNumber($number)
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

    public function base64ToImage($base64_string, $output_file)
    {
        $file = fopen($output_file, "wb");
        fwrite($file, base64_decode($base64_string));
        fclose($file);

        return $output_file;
    }

    public function getExtensionFileFromBase64($base64_string)
    {
        $file = base64_decode($base64_string);

        $f = finfo_open();

        $mime = finfo_buffer($f, $file, FILEINFO_MIME_TYPE);
        if ($mime == 'jpeg') {
            $mime = 'jpg';
        }

        return str_replace('image/', '', $mime);
    }

    // check for exist the key in Illuminate\Support\Facades\Cache
    // if found, so say it's locked
    // if not found, so it's locked about 1 minute and say not lock
    public function checkKeyRedisّIsLock($key_prefix)
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
    public function removeKeyRedisّIsLock($key_prefix)
    {
        Illuminate\Support\Facades\Cache::forget($key_prefix);
        return true;
    }

    public function removeCountryNumberPhoneForIran($phone)
    {
        $country_code = '+98';
        $phone_no     = '+' . $phone;

        // remove +98
        $final = preg_replace('/^\+?98|\|98|\D/', '', ($phone_no));

        return '0' . $final; // output 09168187257
    }

    public function set_queryStringRedis($sessionName, $operatorMeli, $value, $time)
    {
        Illuminate\Support\Facades\Cache::forget('QueryString' . $operatorMeli . $sessionName);
        return Illuminate\Support\Facades\Cache::remember('QueryString' . $operatorMeli . $sessionName, $time, function () use ($value) {
            return $value;
        });
    }

    public function get_queryStringRedis($sessionName, $operatorMeli)
    {
        return Illuminate\Support\Facades\Cache::get('QueryString' . $operatorMeli . $sessionName);
    }

    public function delete_queryStringRedis($sessionName, $operatorMeli)
    {
        return Illuminate\Support\Facades\Cache::forget('QueryString' . $operatorMeli . $sessionName);
    }

    // validate iranian national code
    public function validateNationalCode($nationalCode)
    {
        if (strlen($nationalCode) != 10) {
            return false;
        } else {
            $notValidation = [
                "0000000000",
                "1111111111",
                "2222222222",
                "3333333333",
                "4444444444",
                "5555555555",
                "6666666666",
                "7777777777",
                "8888888888",
                "9999999999",
            ];
            if (in_array($nationalCode, $notValidation)) {
                return false;
            } else {
                if (!preg_match("/^\d{10}$/", $nationalCode)) {
                    return false;
                }

                $check = (int)$nationalCode[9];
                $sum   = array_sum(array_map(function ($x) use ($nationalCode) {
                    return ((int)$nationalCode[$x]) * (10 - $x);
                }, range(0, 8))) % 11;

                return ($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11);
                return true;
            }
        }
    }

    public function generateRandomToken($length)
    {
        $token        = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max          = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
        }

        return $token;
    }

    private function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) {
            return $min;
        } // not so random...
        $log    = ceil(log($range, 2));
        $bytes  = (int)($log / 8) + 1; // length in bytes
        $bits   = (int)$log + 1; // length in bits
        $filter = (int)(1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);

        return $min + $rnd;
    }

    public function openssl_encrypt_project($theOtherKey, $plainTextToEncrypt)
    {
        $chiper       = Config('app.cipher_project', 'AES-256-CBC');
        $newEncrypter = new \Illuminate\Encryption\Encrypter($theOtherKey, $chiper);

        return $newEncrypter->encrypt($plainTextToEncrypt);
    }

    public function openssl_decrypt_project($theOtherKey, $plainTextToEncrypt)
    {
        $chiper    = Config('app.cipher_project', 'AES-256-CBC');
        $encrypted = new \Illuminate\Encryption\Encrypter($theOtherKey, $chiper);

        return $encrypted->decrypt($plainTextToEncrypt);
    }

    // string convert to hexadecimal
    public function helper_strToHex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $ord     = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex     .= substr('0' . $hexCode, -2);
        }

        return strToUpper($hex);
    }

    // hexadecimal convert to string
    public function helper_hexToStr($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }

        return $string;
    }

}
