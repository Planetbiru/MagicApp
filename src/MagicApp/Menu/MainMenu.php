<?php

namespace MagicApp;

use MagicObject\MagicObject;

class MainMenu
{
    /**
     * Menu
     *
     * @var MagicObject[]
     */
    private $menu = array();
    
    /**
     * Group ID
     *
     * @var string
     */
    private $goupId;
    
    /**
     * Menu group ID
     *
     * @var string
     */
    private $menuGroup;
    
    /**
     * Construct menu
     *
     * @param MagicObject[] $menu
     * @param string $grupId
     * @param string $menuGroup
     */
    public function __construct($menu, $grupId = null, $menuGroup = null)
    {
        $this->goupId = $grupId;
        $this->menuGroup = $menuGroup;
        $this->menu = array();
        foreach($menu as $menuItem)
        {
            $menuGroupId = $menuItem->get($grupId);
            if(!isset($this->menu[$menuGroupId]))
            {
                $this->menu[$menuGroupId] = array();
            }
            $this->menu[$menuGroupId] = $menuItem;
        }
    }
}