<?php

/**
 * Products
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Products extends BaseProducts
{
    /**
     * get array for select 
     * @return array
     */
    public static function getArrayForSelect()
    {
        $array = [];
        $product_all = ProductsTable::getInstance()->findAll();
        
        foreach ($product_all as $value) {
            $array[$value->getId()] = $value->getName();
        }
        
        return $array;
    }     
    
    /**
     * get array for select 
     * @return array
     */
    public static function getArrayForSelectByCompany()
    {
        $array = [];
        $product_all = ProductsTable::getInstance()->findAll();
        
        foreach ($product_all as $value) {
            $array[$value->getId()] = $value->getName();
        }
        
        return $array;
    }      
}