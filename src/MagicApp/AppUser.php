<?php

namespace MagicApp;

class AppUser
{
    /**
     * User ID
     *
     * @var string
     */
    protected $userId;
    
    /**
     * User level ID
     *
     * @var string
     */
    protected $userLevelId;

    /**
     * Get user ID
     *
     * @return  string
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set user ID
     *
     * @param  string  $userId  User ID
     *
     * @return  self
     */ 
    public function setUserId(string $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get user level ID
     *
     * @return  string
     */ 
    public function getUserLevelId()
    {
        return $this->userLevelId;
    }

    /**
     * Set user level ID
     *
     * @param  string  $userLevelId  User level ID
     *
     * @return  self
     */ 
    public function setUserLevelId(string $userLevelId)
    {
        $this->userLevelId = $userLevelId;

        return $this;
    }
}