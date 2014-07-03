<?php

/**
 * ReunionContractsIntermediationTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ReunionContractsIntermediationTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ReunionContractsIntermediationTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ReunionContractsIntermediation');
    }
    
    /**
     * get reunion by contract 
     * @param int $id_contract
     */
    public function getReunionByContract($id_contract)
    {
        $q = $this->createQuery()
             ->where('contracts_intermediation_id = ?', $id_contract)
             ->orderBy('date ASC');
        
        return $q->execute();
    }        
}