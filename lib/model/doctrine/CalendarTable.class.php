<?php

/**
 * CalendarTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CalendarTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CalendarTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Calendar');
    }
    
    /**
     * Get pager for list of calendar
     *
     * @param integer $page
     * @param integer $per_page
     * @param string $filter
     * @param string $order
     * @return doctrine pager
     */
    public function getPager($page, $per_page, $filter, $order)
    {
           $oPager = new sfDoctrinePager('Calendar', $per_page);
           $oPager->getQuery()
                ->from('Calendar')
                ->where($filter)
                ->orderBy($order);
           $oPager->setPage($page);
           $oPager->init();

           return $oPager;
    } 
    
    /**
     * get calendar by user and date
     * @param int $user
     * @param int $year
     * @param int $month
     * @param int $day
     * @return object
     */
    public function getCalendarByUserAndDate($user, $year, $month, $day)
    {
        $q = $this->createQuery()
             ->where('app_user_id = ?', $user)
             ->andWhere('year = ?', $year)
             ->andWhere('month = ?', $month)   
             ->andWhere('day = ?', $day)
             ->orderBy('hour_from ASC');
        
        return $q->execute();
    }        
    
    /**
     * get availabilities
     * @param int $year
     * @param int $month
     * @param int $day
     * @param time $hour_from
     * @param time $hour_to
     * @return object
     */
    public function getAvailabilities($year, $month, $day, $hour_from, $id='')
    {
        $q = $this->createQuery()
             ->where('hour_from <= ?', $hour_from)
             ->andWhere('hour_to >= ?', $hour_from)
             ->andWhere('year = ?', $year)
             ->andWhere('month = ?', $month)   
             ->andWhere('day = ?', $day);
       
        if($id!=''){
            $q->andWhere('id != ?', $id);
        }
        
        
        return $q->fetchOne();
                
    }        
}