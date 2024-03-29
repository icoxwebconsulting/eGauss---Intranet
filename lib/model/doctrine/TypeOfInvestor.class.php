<?php

/**
 * TypeOfInvestor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class TypeOfInvestor extends BaseTypeOfInvestor
{
    /**
     * get array for select
     * @return array
     */
    public static function getArrayForSelect()
    {
        $return_array = [];
        $type_of_investor_object = TypeOfInvestorTable::getInstance()->findAll();
        
        foreach ($type_of_investor_object AS $v){
            $return_array[$v->getId()] = $v->getName();
        }
        
        return $return_array;
    }      
}
