<?php

namespace MagicApp;

use Exception;
use MagicObject\Database\PicoDatabase;
use MagicObject\MagicObject;
use MagicObject\Request\PicoRequestBase;
use MagicObject\SecretObject;

/**
 * Class AppUserPermission
 *
 * Manages user permissions for various actions within the application.
 */
class AppUserPermission
{
    /**
     * Application configuration.
     *
     * @var SecretObject
     */
    private $appConfig;
    
    /**
     * Entity representing user roles.
     *
     * @var MagicObject
     */
    private $entity;
    
    /**
     * Current module context.
     *
     * @var PicoModule
     */
    private $currentModule;
    
    /**
     * Permissions flags.
     *
     * @var array
     */
    private $permissions = [
        'allowedList' => false,
        'allowedDetail' => false,
        'allowedCreate' => false,
        'allowedUpdate' => false,
        'allowedDelete' => false,
        'allowedApprove' => false,
        'allowedSortOrder' => false,
        'allowedBatchAction' => false,
    ];
    
    /**
     * Indicates if permissions have been initialized.
     *
     * @var boolean
     */
    private $initialized = false;
    
    /**
     * User level ID.
     *
     * @var string
     */
    private $userLevelId;

    /**
     * Current user object.
     *
     * @var MagicObject
     */
    private $currentUser;

    /**
     * User action to be checked.
     *
     * @var string|null
     */
    private $userAction;

    /**
     * Constructor
     *
     * @param SecretObject $appConfig
     * @param PicoDatabase $database
     * @param MagicObject $appUserRole
     * @param PicoModule $currentModule
     * @param MagicObject $currentUser
     */
    public function __construct($appConfig, $database, $appUserRole, $currentModule, $currentUser)
    {
        $this->appConfig = $appConfig;
        $this->entity = $appUserRole;

        if ($this->entity !== null && ($this->entity->currentDatabase() === null || !$this->entity->currentDatabase()->isConnected())) {
            $this->entity->currentDatabase($database);
        }

        $this->currentModule = $currentModule;
        $this->currentUser = $currentUser;
        $this->userLevelId = $currentUser->getUserLevelId();
    }

    /**
     * Load permissions based on the user role.
     *
     * @return void
     */
    public function loadPermission()
    {
        if ($this->appConfig->getRole()->getBypassRole()) {
            $this->permissions = array_fill_keys(array_keys($this->permissions), true);
        } else {
            try {
                if ($this->entity !== null) {
                    $this->entity->findOneByModuleNameAndUserLevelIdAndActive($this->currentModule->getModuleName(), $this->userLevelId, true);
                    foreach ($this->permissions as $key => &$value) {
                        $value = $this->entity->{"get" . ucfirst(substr($key, 7))}();
                    }
                }
                $this->initialized = true;
            } catch (Exception $e) {
                // Handle exceptions as necessary
            }
        }

        $this->permissions['allowedBatchAction'] = $this->permissions['allowedUpdate'] || $this->permissions['allowedDelete'];
        $this->initialized = true;
    }

    /**
     * Check if the user has access based on the action.
     *
     * @param PicoRequestBase $inputGet
     * @param PicoRequestBase $inputPost
     * @return boolean
     */
    public function allowedAccess($inputGet, $inputPost)
    {
        $userAction = $inputPost->getUserAction() ?? $inputGet->getUserAction();

        if (!$this->currentModule->getAppModule()->issetModuleId()) {
            try {
                $this->currentModule->getAppModule()->findOneByModuleCode($this->currentModule->getModuleName());
            } catch (Exception $e) {
                // Handle exceptions as necessary
            }
        }

        return isset($userAction) && !empty($userAction)
            ? $this->isAllowedTo($userAction)
            : $this->isAllowedTo(UserAction::SHOW_ALL);
    }

    /**
     * Check permissions and invoke a callback if access is denied.
     *
     * @param PicoRequestBase $inputGet
     * @param PicoRequestBase $inputPost
     * @param callable $callbackForbidden
     * @return void
     */
    public function checkPermission($inputGet, $inputPost, $callbackForbidden)
    {
        if (isset($callbackForbidden) && is_callable($callbackForbidden)) {
            $userAction = $inputPost->getUserAction() ?? $inputGet->getUserAction();
            if (isset($userAction) && !$this->isAllowedTo($userAction)) {
                $this->userAction = $userAction;
                call_user_func($callbackForbidden, $this->appConfig);
            }
        }
    }

    /**
     * Determine if the user is allowed to perform a specific action.
     *
     * @param string $userAction
     * @return boolean
     */
    public function isAllowedTo($userAction)
    {
        if ($this->currentModule->getAppModule()->getSpecialAccess() && $this->getCurrentUser()->getUserLevel()->getSpecialAccess()) {
            $this->permissions = array_fill_keys(array_keys($this->permissions), true);
            return true;
        }

        $forbidden = false;

        if ($userAction !== null) {
            $forbidden =
                ($userAction == UserAction::SHOW_ALL && !$this->isAllowedList()) ||
                ($userAction == UserAction::CREATE && !$this->isAllowedCreate()) ||
                ($userAction == UserAction::UPDATE && !$this->isAllowedUpdate()) ||
                ($userAction == UserAction::ACTIVATE && !$this->isAllowedUpdate()) ||
                ($userAction == UserAction::DELETE && !$this->isAllowedDelete()) ||
                ($userAction == UserAction::DETAIL && !$this->isAllowedDetail()) ||
                ($userAction == UserAction::SORT_ORDER && !$this->isAllowedSortOrder()) ||
                ($userAction == UserAction::APPROVE && !$this->isAllowedApprove()) ||
                ($userAction == UserAction::REJECT && !$this->isAllowedApprove());
        }

        return !$forbidden;
    }

    /**
     * Check if the user has permission for batch actions.
     *
     * @return boolean
     */
    public function isAllowedBatchAction()
    {
        return $this->permissions['allowedBatchAction'];
    }

    /**
     * Check if the user has permission to approve actions.
     *
     * @return boolean
     */
    public function isAllowedApprove()
    {
        $this->initializeIfNeeded();
        return $this->permissions['allowedApprove'];
    }

    /**
     * Check if the user has permission to view the list.
     *
     * @return boolean
     */
    public function isAllowedList()
    {
        $this->initializeIfNeeded();
        return $this->permissions['allowedList'];
    }

    /**
     * Check if the user has permission to view details.
     *
     * @return boolean
     */
    public function isAllowedDetail()
    {
        $this->initializeIfNeeded();
        return $this->permissions['allowedDetail'];
    }

    /**
     * Check if the user has permission to create new items.
     *
     * @return boolean
     */
    public function isAllowedCreate()
    {
        $this->initializeIfNeeded();
        return $this->permissions['allowedCreate'];
    }

    /**
     * Check if the user has permission to update existing items.
     *
     * @return boolean
     */
    public function isAllowedUpdate()
    {
        $this->initializeIfNeeded();
        return $this->permissions['allowedUpdate'];
    }

    /**
     * Check if the user has permission to delete items.
     *
     * @return boolean
     */
    public function isAllowedDelete()
    {
        $this->initializeIfNeeded();
        return $this->permissions['allowedDelete'];
    }

    /**
     * Check if the user has permission to sort order.
     *
     * @return boolean
     */
    public function isAllowedSortOrder()
    {
        $this->initializeIfNeeded();
        return $this->permissions['allowedSortOrder'];
    }

    /**
     * Get user level ID.
     *
     * @return string
     */
    public function getUserLevelId()
    {
        return $this->userLevelId;
    }

    /**
     * Get the current user object.
     *
     * @return MagicObject
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * Get the user action being checked.
     *
     * @return string|null
     */
    public function getUserAction()
    {
        return $this->userAction;
    }

    /**
     * Set allowed sort order to false.
     *
     * @return self
     */
    public function setAllowedSortOrderFalse()
    {
        $this->permissions['allowedSortOrder'] = false;
        return $this;
    }

    /**
     * Initialize permissions if not already done.
     *
     * @return void
     */
    private function initializeIfNeeded()
    {
        if (!$this->initialized) {
            $this->loadPermission();
        }
    }
}
