<?php

use MagicApp\Field;
use MagicApp\Menu\AccountMenu;

require_once dirname(__DIR__) . "/vendor/autoload.php";

echo Field::of()->CobaSaja;

$menu = new AccountMenu($test);
$string = $menu->render($menu->load(), function($data){
    // do something here
    $rows = $data->getResult();
    foreach($rows as $row)
    {
        echo $row;
    }
});
