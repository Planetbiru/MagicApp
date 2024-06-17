<?php

namespace MagicApp;

use MagicObject\MagicObject;
use MagicObject\SecretObject;

class AppInclude
{
    /**
     * Main header
     *
     * @param string $dir
     * @param MagicObject|SecretObject $config
     * @return string
     */
    public static function mainAppHeader($dir, $config)
    {
        if($config != null)
        {
            return $dir."/".$config->getBaseIncludeDirectory()."/".$config->getInludeHeaderFile();
        }
        else
        {
            return $dir."/inc.app/header.php";
        }
    }
    
    /**
     * Main footer
     *
     * @param string $dir
     * @param MagicObject|SecretObject $config
     * @return string
     */
    public static function mainAppFooter($dir, $config)
    {
        if($config != null)
        {
            return $dir."/".$config->getBaseIncludeDirectory()."/".$config->getInludeFooterFile();
        }
        else
        {
            return $dir."/inc.app/footer.php";
        }
    }
}