# super-tools
super tools is practical function in PHP

get package by
--------------
```bash
1- composer require "roshandelpoor/super-tools"

2-composer dumpo-autoload

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
