<?php

/**
 * NotificationsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NotificationsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object NotificationsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Notifications');
    }
    
    /**
     * get notifications by user
     * @return object
     */
    public function getNotifications($app_user_id)
    {
        $q = $this->createQuery()
             ->where('app_user_id IS NULL OR app_user_id = '.$app_user_id)   
             ->orderBy('id DESC')
             ->limit(10);
        return $q->execute();
    }        
}