<?php

/**
 * VideosRegisteredCompaniesTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class VideosRegisteredCompaniesTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object VideosRegisteredCompaniesTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('VideosRegisteredCompanies');
    }
    
    /**
     * get video by company
     * @param int $id_company
     * @return object
     */
    public function getVideoByCompany($id_company)
    {
        $q = $this->createQuery()
             ->where('information_id IS NULL AND registered_companies_id = '.$id_company)
             ->orderBy('id DESC');
        
        return $q->execute();
    }        
}