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
    public function checkKeyRedisIsLock($key_prefix)
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
    public function removeKeyRedisIsLock($key_prefix)
    {
        Illuminate\Support\Facades\Cache::forget($key_prefix);
        return true;
    }

    public function removeCountryNumberPhoneForIran($phone)
    {
        $country_code = '+98';
        $phone_no = '+' . $phone;

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

                $check = (int) $nationalCode[9];
                $sum = array_sum(array_map(function ($x) use ($nationalCode) {
                    return ((int) $nationalCode[$x]) * (10 - $x);
                }, range(0, 8))) % 11;

                return ($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11);
                return true;
            }
        }
    }

    public function generateRandomToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

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
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);

        return $min + $rnd;
    }

    public function openssl_encrypt_project($theOtherKey, $plainTextToEncrypt)
    {
        $chiper = Config('app.cipher_project', 'AES-256-CBC');
        $newEncrypter = new \Illuminate\Encryption\Encrypter($theOtherKey, $chiper);

        return $newEncrypter->encrypt($plainTextToEncrypt);
    }

    public function openssl_decrypt_project($theOtherKey, $plainTextToEncrypt)
    {
        $chiper = Config('app.cipher_project', 'AES-256-CBC');
        $encrypted = new \Illuminate\Encryption\Encrypter($theOtherKey, $chiper);

        return $encrypted->decrypt($plainTextToEncrypt);
    }

    // string convert to hexadecimal
    public function helper_strToHex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0' . $hexCode, -2);
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

    // checking iranian phone number 09.........
    public function isMobile($mobile)
    {
        $mobile = str_replace('-', '', $mobile);

        preg_match('/(09)?9\d{9}/', $mobile, $matches);
        if (isset($matches[0]) && is_numeric($mobile) && strlen($mobile) == 11) {
            return true;
        }

        return false;
    }

    public function isShaba($number)
    {
        $number = str_replace('-', '', $number);

        if (preg_match("/^[0-9]{16}$/", $number)) {
            return true;
        }

        return false;
    }

    public function deviceIsMobile()
    {
        $useragent = null;
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $useragent = $_SERVER['HTTP_USER_AGENT'];
        }

        if (
            preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent)
            || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))
        ) {

            return true;
        }

        return false;
    }

    public function dateCheckBetweenTwoDates($dateGoal, $dateStart, $dateEnd)
    {
        $check_date = date('Y-m-d H:i:s', strtotime($dateGoal));
        $contract_Start = date('Y-m-d H:i:s', strtotime($dateStart));
        $contract_End = date('Y-m-d H:i:s', strtotime($dateEnd));

        if (($check_date >= $contract_Start) && ($check_date <= $contract_End)) {
            return 'yes';
        }

        return 'no';
    }

    // english name days convert to persian name
    public function nameDayEnglishToPersian($string)
    {
        return strtr(
            $string,
            [
                'Saturday' => 'شنبه',
                'Sunday' => 'یک شنبه',
                'Monday' => 'دوشنبه',
                'Tuesday' => 'سه شنبه',
                'Wednesday' => 'چهارشنبه',
                'Thursday' => 'پنج شنبه',
                'Friday' => 'جمعه',
            ]
        );
    }

    // secure password
    function generateSecurePassword($length = 12)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    function stringSearch($stringText, $serach)
    {
        if (strpos($stringText, $serach) !== false) {
            return true;
        } else {
            return false;
        }
    }
}