<?php

use MagicApp\AppModule;
use MagicObject\Database\PicoDatabase;
use MagicObject\SecretObject;

class UserPermission{
    
    /**
     * Application config
     *
     * @var SecretObject
     */
    private $appConfig;
    
    /**
     * Database
     *
     * @var PicoDatabase
     */
    private $database;
    
    /**
     * Module
     *
     * @var AppModule
     */
    private $currentModule;
    
    /**
     * Allowed show list
     *
     * @var boolean
     */
    private $allowedList;
    
    /**
     * Allowed show detail
     *
     * @var boolean
     */
    private $allowedDetail;
    
    /**
     * Allowed create
     *
     * @var boolean
     */
    private $allowedCreate;
    
    /**
     * Allowed update
     *
     * @var boolean
     */
    private $allowedUpdate;
    
    /**
     * Allowed delete
     *
     * @var boolean
     */
    private $allowedDelete;
    
    /**
     * Allowed approve/reject
     *
     * @var boolean
     */
    private $allowedApprove;
    
    /**
     * Allowed short order
     *
     * @var boolean
     */
    private $allowedSortOrder;
    
    /**
     * Check if object has been initialize
     *
     * @var boolean
     */
    private $initialized = false;
    
    /**
     * Constructor
     *
     * @param SecretObject $appConfig
     * @param PicoDatabase $database
     * @param AppModule $currentModule
     */
    public function __construct($appConfig, $database, $currentModule)
    {
        $this->appConfig = $appConfig;
        $this->database = $database;
        $this->currentModule = $currentModule;
    }
    
    public function loadPermission()
    {
        $this->allowedList =  true;
        $this->allowedDetail =  true;
        $this->allowedCreate =  true;
        $this->allowedUpdate =  true;
        $this->allowedDelete =  true;
        $this->allowedApprove =  true;
        $this->allowedSortOrder =  true;
        
        $this->initialized = true;
    }
    
    
    
    /**
     * Check if user has permission to approve
     *
     * @return boolean
     */
    public function isAllowedApprove()
    {
        if($this->initialized)
        {
            $this->loadPermission();
        }
        
        return $this->allowedApprove;
    }

    /**
     * Get allowed show list
     *
     * @return  boolean
     */ 
    public function isAllowedList()
    {
        if($this->initialized)
        {
            $this->loadPermission();
        }
        
        return $this->allowedList;
    }

    /**
     * Get allowed show detail
     *
     * @return  boolean
     */ 
    public function isAllowedDetail()
    {
        if($this->initialized)
        {
            $this->loadPermission();
        }
        
        return $this->allowedDetail;
    }

    /**
     * Get allowed create
     *
     * @return  boolean
     */ 
    public function isAllowedCreate()
    {
        if($this->initialized)
        {
            $this->loadPermission();
        }
        
        return $this->allowedCreate;
    }

    /**
     * Get allowed update
     *
     * @return  boolean
     */ 
    public function isAllowedUpdate()
    {
        if($this->initialized)
        {
            $this->loadPermission();
        }
        
        return $this->allowedUpdate;
    }

    /**
     * Get allowed delete
     *
     * @return  boolean
     */ 
    public function isAllowedDelete()
    {
        if($this->initialized)
        {
            $this->loadPermission();
        }
        
        return $this->allowedDelete;
    }

    /**
     * Get allowed short order
     *
     * @return  boolean
     */ 
    public function isAllowedSortOrder()
    {
        if($this->initialized)
        {
            $this->loadPermission();
        }
        
        return $this->allowedSortOrder;
    }
}