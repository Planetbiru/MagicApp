<?php

use MagicApp\Field;
use MagicApp\Menu\AccountMenu;

require_once dirname(__DIR__) . "/vendor/autoload.php";

echo Field::of()->CobaSaja;

try
{
    $string = $menu->loadAndRender(function($data){
        // do something here
        $rows = $data->getResult();
        foreach($rows as $row)
        {
            echo $row;
        }
    });
}
catch(Exception $e)
{
    $string = "";
}