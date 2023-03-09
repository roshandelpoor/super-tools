# Super Tools
Super Tools is a Laravel package that provides practical functions to make your coding life easier. It includes a variety of tools that can be used in any Laravel project.

## Installation

You can install Super Tools using Composer. Simply run the following command:
--------------
```bash
1- composer require "roshandelpoor/super-tools"

2- composer dump-autoload

3- add this line in config/app.php -> in part 'providers' => []
   Super\SuperToolsServiceProvider::class,
```

## Usage

To use Super Tools in your project, simply include the autoload file and start using the functions. Here's an example:
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

## Functions

Super Tools includes the following functions:
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
- isMobile
- isShaba
- deviceIsMobile
- dateCheckBetweenTwoDates
- nameDayEnglishToPersian
- generateSecurePassword
- stringSearch
- getIP
```

## Contributing

If you find any bugs or have suggestions for new features, feel free to open an issue or submit a pull request on GitHub.

## License

Super Tools is open-source software licensed under the MIT license.
