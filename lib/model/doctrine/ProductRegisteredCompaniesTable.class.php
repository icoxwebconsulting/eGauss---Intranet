<?php

/**
 * ProductRegisteredCompaniesTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ProductRegisteredCompaniesTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ProductRegisteredCompaniesTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ProductRegisteredCompanies');
    }
    
    /**
     * Get array of all for select tag
     * @param string $id 
     * @return array
     */
    public function getAllForSelectCompanyAssociated($id)
    {
           $arr_options = array();
           
           $q = Doctrine_Query::create()
                   ->select('pr.*, rc.id AS id, rc.name AS name, tc.id AS tc_id, tc.name AS type')
                   ->from('ProductRegisteredCompanies pr')
                   ->leftJoin('pr.RegisteredCompanies rc')
                   ->leftJoin('rc.TypeCompanies tc')
                   ->where('pr.product_id = ?', $id)
                   ->orderBy('id');
           
           $d = $q->fetchArray();

           foreach ($d as $value) {
                   $type = $value['tc_id']==1?' ('.$value['type'].')':'';
                   $arr_options[$value['id']] = $value['name'].$type;
           }
           return $arr_options;
    }
    
    /**
     * delete company not in product
     * @param string $array_user
     * @param int $company_id
     * @return delete
     */
    public function deleteCompanyNotInProduct($array_company, $product_id)
    {
        $q = $this->createQuery()
             ->where('product_id = ?', $product_id)
             ->andWhere('registered_companies_id NOT IN '.$array_company )
             ->delete();
        
        return $q->execute();
    }    
}