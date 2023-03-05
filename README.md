# super-tools
super tools is practical function in PHP

get package by
--------------
```bash
1- composer require "roshandelpoor/super-tools"

2- composer dump-autoload

3- add this line in config/app.php
Super\SuperToolsServiceProvider::class,
```

example call function in class
------------------------------

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Super\Tools;

class TestPackageController extends Controller
{
    public function package () {
        $superToolsPackage = new Tools();
        echo $superToolsPackage->persianToEnglishNumber('۱۴۰۲');
    }
}
```

List Functions in this package
------------------------------

```php
- persianToEnglishNumber
- englishToPersianNumber
- base64ToImage
- getExtensionFileFromBase64
- checkKeyRedisIsLock
- removeKeyRedisIsLock
- removeCountryNumberPhoneForIran
- set_queryStringRedis
- get_queryStringRedis
- delete_queryStringRedis
- validateNationalCode
- generateRandomToken
- openssl_encrypt_project
- openssl_decrypt_project
- helper_strToHex
- helper_hexToStr
- is_mobile
- is_shaba
- device_is_mobile
- dateCheckBetweenTwoDates
- nameDayEnglishToPersian
```