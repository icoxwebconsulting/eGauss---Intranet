<?php

/**
 * ProductsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ProductsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ProductsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Products');
    }
    
    /**
     * Get pager for list
     *
     * @param integer $page
     * @param integer $per_page
     * @param string $filter
     * @param string $order
     * @return doctrine pager
     */
    public function getPager($page, $per_page, $filter, $order)
    {
            $oPager = new sfDoctrinePager('Products', $per_page);
            $oPager->getQuery()
                ->from('Products p')
                ->where($filter)
                ->orderBy($order);
            $oPager->setPage($page);
            $oPager->init();

            return $oPager;
    }    
}