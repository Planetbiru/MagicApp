<?php

use MagicApp\AppDto\ResponseDto\DataMap;
use MagicApp\AppDto\ResponseDto\DetailDataDto;
use MagicApp\AppDto\ResponseDto\DetailDto;
use MagicApp\AppDto\ResponseDto\ListDataDto;
use MagicApp\AppDto\ResponseDto\ListDataTitleDto;
use MagicApp\AppDto\ResponseDto\ListDto;
use MagicApp\AppDto\ResponseDto\MetadataDto;
use MagicObject\MagicObject;

require_once dirname(__DIR__) . "/vendor/autoload.php";

/**
 * @JSON(property-naming-strategy="SNAKE_CASE")
 */
class Apa extends MagicObject
{
    
}
/*
$listDto = new ListDto("001", "Success", new ListDataDto());

$listDto->appendTitle(new ListDataTitleDto("apaId", "ID", true, "DESC"));
$listDto->appendTitle(new ListDataTitleDto("name", "Nama", true));
$listDto->appendTitle(new ListDataTitleDto("gender", "Jenis Kelamin", false));
$listDto->appendTitle(new ListDataTitleDto("active", "Aktif", true));

$listDto->appendDataMap(new DataMap('active', [true=>'Ya', false=>'Tidak']));
$listDto->appendDataMap(new DataMap('gender', ['M'=>'Laki-Laki']));

$listDto->addPrimaryKeyName("apaId", "string");

$listDto->appendData(new Apa(['apaId'=>'1234', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));
$listDto->appendData(new Apa(['apaId'=>'1235', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));
$listDto->appendData(new Apa(['apaId'=>'1236', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));
$listDto->appendData(new Apa(['apaId'=>'1237', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));
$listDto->appendData(new Apa(['apaId'=>'1238', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));
$listDto->appendData(new Apa(['apaId'=>'1239', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));
$listDto->appendData(new Apa(['apaId'=>'1240', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));
$listDto->appendData(new Apa(['apaId'=>'1241', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));
$listDto->appendData(new Apa(['apaId'=>'1242', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));
$listDto->appendData(new Apa(['apaId'=>'1243', 'name'=>'Coba', 'gender'=>'M', 'active'=>"Ya"]), new MetadataDto(['apaId'=>'1234'], 0, true));

echo $listDto;
*/

$detailDto = new DetailDto("001", "Success", new DetailDataDto());
$detailDto->setMetadata(new MetadataDto(['apaId'=>'1234'], 0, true));

$detailDto->addData('apaId', '1234', 'string', 'ID', false, false, '1234');
echo $detailDto;