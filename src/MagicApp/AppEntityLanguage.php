<?php

namespace MagicApp;

use MagicObject\Language\PicoEntityLanguage;
use MagicObject\MagicObject;
use MagicObject\SecretObject;

class AppEntityLanguage extends PicoEntityLanguage
{
    /**
     * App config
     *
     * @var SecretObject
     */
    private $appConfig;
    /**
     * Constructor
     *
     * @param MagicObject $entity
     * @param SecretObject $appConfig
     */
    public function __construct($entity, $appConfig)
    {
        parent::__construct($entity);
        $this->appConfig = $appConfig;
    }
}