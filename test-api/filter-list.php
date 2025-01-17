<?php

use MagicApp\AppDto\MocroServices\InputField;
use MagicApp\AppDto\MocroServices\InputFieldFilter;
use MagicApp\AppDto\MocroServices\InputFieldOption;
use MagicApp\AppDto\MocroServices\InputFieldValue;
use MagicApp\AppDto\MocroServices\ResponseBody;
use MagicApp\AppDto\MocroServices\UserFormFilterList;

require_once dirname(__DIR__) . "/vendor/autoload.php";


$data = new UserFormFilterList();

$data->addFilter(
    new InputFieldFilter(
        new InputField("adminId", "Admin"), 
        "select", 
        "string", 
        "map", 
        [
            new InputFieldOption("admin", "Administrator")
        ], 
        null, 
        new InputFieldValue("admin", "Administrator")
    )
);

$data->addFilter(
    new InputFieldFilter(
        new InputField("name", "Name"), 
        "text", 
        "string", 
        null, 
        new InputFieldValue("Administrator", "Administrator")
    )
);

echo ResponseBody::getInstance()
    ->setData($data)
    ->switchCaseTo("camelCase")
    ->setResponseCode("000")
    ->setResponseText("Success")
    ;