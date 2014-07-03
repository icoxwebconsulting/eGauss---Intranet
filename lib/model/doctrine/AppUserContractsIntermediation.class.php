<?php

/**
 * AppUserContractsIntermediation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class AppUserContractsIntermediation extends BaseAppUserContractsIntermediation
{
    /**
     * set customer in contract
     * @param int $contract
     * @param array $customer_post
     * @param int $id
     */
    public static function setCustomerInContract($contract, $customer_post, $id = NULL)
    {
        if ($id)
        {
          $d_customer = AppUserContractsIntermediationTable::getInstance()->findByContractsIntermediationId($id);  
          foreach ($d_customer as $d){
            $array_customer[$d->getAppUserId()] = $d->getAppUserId();           
          }

        }
        $array_customer_active = '(0,';
        foreach ($customer_post AS $k => $v)
        {
            if($id)
            {
                if(empty($array_customer[$v])){
                    self::setNewAppUserContract($v, $contract);
                }

            }
            else
            {
                self::setNewAppUserContract($v, $contract);
            }    

            $array_customer_active .= $v.',';
        }
        $string_customer = substr($array_company_active, 0, -1).')';

        if($string_company && $id){
          $d_customer_not_in_contract = AppUserContractsIntermediationTable::getInstance()->deleteCustomerNotInContract($string_customer, $contract);  
        }
    }    
    
    /**
     * set new app user contract
     * @param int $customer
     * @param int $contract
     */
    public function setNewAppUserContract($customer, $contract)
    {
        $app_user = new AppUserContractsIntermediation();
        $app_user->setAppUserId($customer);
        $app_user->setContractsIntermediationId($contract);
        $app_user->save();
    }        
}
