<?php

use MagicApp\AppDto\ResponseDto\DataMap;
use MagicApp\AppDto\ResponseDto\ListDataDto;
use MagicApp\AppDto\ResponseDto\ListDataTitleDto;
use MagicApp\AppDto\ResponseDto\ListDto;
use MagicObject\MagicObject;

require_once dirname(__DIR__) . "/vendor/autoload.php";

/**
 * @JSON(property-naming-strategy="SNAKE_CASE")
 */
class Apa extends MagicObject
{
    
}

$listDto = new ListDto("001", "Success", new ListDataDto());

$listDto->getData()->appendTitle(new ListDataTitleDto("apaId", "ID", true, "DESC"));
$listDto->getData()->appendTitle(new ListDataTitleDto("name", "Nama", true));
$listDto->getData()->appendTitle(new ListDataTitleDto("gender", "Jenis Kelamin", false));
$listDto->getData()->appendTitle(new ListDataTitleDto("active", "Aktif", true));

$listDto->getData()->appendDataMap(new DataMap('active', [true=>'Ya', false=>'Tidak']));
$listDto->getData()->appendDataMap(new DataMap('gender', ['M'=>'Laki-Laki']));

$listDto->getData()->addPrimaryKeyName("apaId", "string");

$listDto->getData()->appendData(new Apa(['apaId'=>'1234', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));
$listDto->getData()->appendData(new Apa(['apaId'=>'1235', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));
$listDto->getData()->appendData(new Apa(['apaId'=>'1236', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));
$listDto->getData()->appendData(new Apa(['apaId'=>'1237', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));
$listDto->getData()->appendData(new Apa(['apaId'=>'1238', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));
$listDto->getData()->appendData(new Apa(['apaId'=>'1239', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));
$listDto->getData()->appendData(new Apa(['apaId'=>'1240', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));
$listDto->getData()->appendData(new Apa(['apaId'=>'1241', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));
$listDto->getData()->appendData(new Apa(['apaId'=>'1242', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));
$listDto->getData()->appendData(new Apa(['apaId'=>'1243', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya", "metadata"=>["waitingFor"=>0, "active"=>true]]));

echo $listDto;