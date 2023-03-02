# super-tools
super tools is practical function in PHP

get package by
--------------
```bash
1- composer require "roshandelpoor/super-tools"

2-composer dumpo-autoload

3- add this line in config/app.phpconfig/app.php
Super\SuperToolsServiceProvider::class,
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
