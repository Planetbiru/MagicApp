<?php

namespace MagicApp;

use MagicObject\Request\InputServer;

class AppModule
{
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
    
    public function __construct($moduleName)
    {
        $this->moduleName = $moduleName;
        $inputServer = new InputServer();
        $this->phpSelf = $inputServer->getPhpSelf();
    }    
    
    /**
     * get redirect URL
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
        $urls[] = $this->phpSelf;
        if($userAction != null)
        {
            $params[] = "user_action=".urlencode($userAction);
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