<?php

namespace MagicApp;

use MagicObject\Request\InputServer;
use MagicObject\SecretObject;
use MagicObject\Util\PicoStringUtil;

class AppModule
{
    const HEADER_LOCATION = "Location: ";
    
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
    
    /**
     * Constructor
     *
     * @param SecretObject $appConfig
     * @param string $moduleName
     */
    public function __construct($appConfig, $moduleName)
    {
        $this->appConfig = $appConfig;
        $this->moduleName = $moduleName;
        $inputServer = new InputServer();
        $this->phpSelf = $inputServer->getPhpSelf();
    }

    /**
     * Redirect to itself
     *
     * @return void
     */
    public function redirectToItself()
    {
        header(self::HEADER_LOCATION.$_SERVER['REQUEST_URI']);
        exit();
    }

    /**
     * Redirect to itself with show require approval only
     *
     * @return void
     */
    public function redirectToItselfWithRequireApproval()
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        if(stripos($uri, "?") !== false)
        {
            $arr = explode("?", $uri, 2);
            parse_str($arr[1], $params);
            $module = $arr[0];
        }
        else
        {
            $params = array();
            $module = $uri;
        }
        $params[] = "show_require_approval_only=true";
        $uri = $module."?".implode("&", $params);
        header(self::HEADER_LOCATION.$uri);
        exit();
    }
    
    /**
     * Redirect to
     *
     * @param string $userAction Current action
     * @param string $parameterName
     * @param string $parameterValue
     * @return void
     */
    public function redirectTo($userAction = null, $parameterName = null, $parameterValue = null)
    {
        $url = $this->getRedirectUrl($userAction, $parameterName, $parameterValue);
        header(self::HEADER_LOCATION.$url);
        exit();
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