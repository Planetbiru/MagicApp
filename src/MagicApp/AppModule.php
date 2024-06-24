<?php

namespace MagicApp;

use MagicObject\Request\InputServer;
use MagicObject\SecretObject;
use MagicObject\Util\PicoStringUtil;

class AppModule
{
    /**
     * App Config
     *
     * @var SecretObject
     */
    private $appConfig;
    
    /**
     * Module name
     *
     * @var string
     */
    private $moduleName = "";
    
    /**
     * PHP self
     *
     * @var string
     */
    private $phpSelf = "";
    
    public function __construct($appConfig, $moduleName)
    {
        $this->appConfig = $appConfig;
        $this->moduleName = $moduleName;
        $inputServer = new InputServer();
        $this->phpSelf = $inputServer->getPhpSelf();
    }    
    
    /**
     * Get redirect URL
     *
     * @param string $userAction
     * @param string $parameterName
     * @param string $parameterValue
     * @param string[] $additionalParams
     * @return string
     */
    public function getRedirectUrl($userAction = null, $parameterName = null, $parameterValue = null, $additionalParams = null)
    {
        $urls = array();
        $params = array();
        $phpSelf = $this->phpSelf;
        
        if($this->appConfig->getModule() != null && $this->appConfig->getModule()->getHideExtension() && PicoStringUtil::endsWith($phpSelf, ".php"))
        {
            $phpSelf = substr($phpSelf, 0, strlen($phpSelf) - 4);
        }
        
        $urls[] = $phpSelf;
        if($userAction != null)
        {
            $params[] = UserAction::USER_ACTION."=".urlencode($userAction);
        }
        if($parameterName != null)
        {
            $params[] = urlencode($parameterName)."=".urlencode($parameterValue);
        }
        if($additionalParams != null && is_array($additionalParams))
        {
            $additionalParamsKey = array_keys($additionalParams);
            foreach($additionalParams as $paramName=>$paramValue)
            {
                if($parameterName == null || !in_array($parameterName, $additionalParamsKey))
                {
                    $params[] = urlencode($paramName)."=".urlencode($paramValue);
                }
            }
        }
        if(!empty($params))
        {
            $urls[] = implode("&", $params);
        }
        return implode("?", $urls);
    }
}