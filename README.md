# super-tools
super tools is practical function in PHP

get package by
--------------
```bash
composer require "roshandelpoor/super-tools"
```

example call function in class
------------------------------

```php
<?php
use Super\Tools;

class HomeController extends Controller
{
    public function index()
    {
        $superToolsPackage = app('super-tools');
        echo $superToolsPackage->persianToEnglishNumber('۱۴۰۲'); // 1402
    }
}
```
