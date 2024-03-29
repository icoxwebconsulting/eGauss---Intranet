<?php

/**
 * GeneralTheme
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class GeneralTheme extends BaseGeneralTheme
{
    /**
     * get array for select
     * @return array
     */
    public static function getArrayForSelect()
    {
        $return_array = [];
        $general_theme_object = GeneralThemeTable::getInstance()->findAll();
        
        foreach ($general_theme_object AS $v){
            $return_array[$v->getId()] = $v->getName();
        }
        
        return $return_array;
    }        
}
