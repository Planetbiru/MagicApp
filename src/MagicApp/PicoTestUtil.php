<?php

namespace MagicApp;

class PicoTestUtil
{
    /**
     * Add class compare data
     *
     * @param boolean $div
     * @return string
     */
    public static function classCompareData($div)
    {
        return $div ? 'compare-data data-different':'compare-data';
    }
}