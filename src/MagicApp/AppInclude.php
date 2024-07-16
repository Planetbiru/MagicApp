<?php

namespace MagicApp;

use MagicObject\MagicObject;
use MagicObject\SecretObject;
use MagicObject\Util\PicoStringUtil;

class AppInclude
{
    /**
     * App config
     *
     * @var SecretObject
     */
    private $appConfig;
    
    /**
     * Current module
     *
     * @var PicoModule
     */
    private $currentModule;
    
    public function __construct($appConfig, $currentModule)
    {
        $this->appConfig = $appConfig;
        $this->currentModule = $currentModule;
    }
    /**
     * Main header
     *
     * @param string $dir
     * @param MagicObject|SecretObject $config
     * @return string
     */
    public function mainAppHeader($dir, $config = null)
    {
        if(!isset($config))
        {
            $config = $this->appConfig;
        }
        $path = $config->getBaseIncludeDirectory()."/".$config->getInludeHeaderFile();
        if($config != null && PicoStringUtil::endsWith($path, ".php") && file_exists($path))
        {
            return $path;
        }
        else
        {
            return $dir . "/inc.app/header.php";
        }
    }
    
    /**
     * Main footer
     *
     * @param string $dir
     * @param MagicObject|SecretObject $config
     * @return string
     */
    public function mainAppFooter($dir, $config = null)
    {
        if(!isset($config))
        {
            $config = $this->appConfig;
        }
        $path = $config->getBaseIncludeDirectory()."/".$config->getInludeFooterFile();
        if($config != null && PicoStringUtil::endsWith($path, ".php") && file_exists($path))
        {
            return $path;
        }
        else
        {
            return $dir . "/inc.app/footer.php";
        }
    }

    /**
     * Forbidden
     *
     * @param string $dir
     * @param MagicObject|SecretObject $config
     * @return string
     */
    public function appForbiddenPage($dir, $config = null)
    {
        if(!isset($config))
        {
            $config = $this->appConfig;
        }
        $path = $config->getBaseIncludeDirectory()."/".$config->getInludeForbiddenFile();
        if($config != null && PicoStringUtil::endsWith($path, ".php") && file_exists($path))
        {
            return $path;
        }
        else
        {
            return $dir . "/inc.app/403.php";
        }
    }

    /**
     * Page not found
     *
     * @param string $dir
     * @param MagicObject|SecretObject $config
     * @return string
     */
    public function appNotFoundPage($dir, $config = null)
    {
        if(!isset($config))
        {
            $config = $this->appConfig;
        }
        $path = $config->getBaseIncludeDirectory()."/".$config->getInludeNotFoundFile();
        if($config != null && PicoStringUtil::endsWith($path, ".php") && file_exists($path))
        {
            return $path;
        }
        else
        {
            return $dir . "/inc.app/404.php";
        }
    }

    /**
     * Get app config
     *
     * @return  SecretObject
     */ 
    public function getAppConfig()
    {
        return $this->appConfig;
    }

    /**
     * Set app config
     *
     * @param  SecretObject  $appConfig  App config
     *
     * @return  self
     */ 
    public function setAppConfig($appConfig)
    {
        $this->appConfig = $appConfig;

        return $this;
    }

    /**
     * Get current module
     *
     * @return  PicoModule
     */ 
    public function getCurrentModule()
    {
        return $this->currentModule;
    }

    /**
     * Set current module
     *
     * @param  PicoModule  $currentModule  Current module
     *
     * @return  self
     */ 
    public function setCurrentModule($currentModule)
    {
        $this->currentModule = $currentModule;

        return $this;
    }
}