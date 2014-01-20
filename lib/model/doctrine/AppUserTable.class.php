<?php

/**
 * AppUserTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AppUserTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object AppUserTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('AppUser');
    }
    
    /**
     * Get pager for list of users
     *
     * @param integer $page
     * @param integer $per_page
     * @param string $filter
     * @param string $order
     * @return doctrine pager
     */
    public function getPager($page, $per_page, $filter, $order)
    {
        $oPager = new sfDoctrinePager('AppUser', $per_page);
        $oPager->getQuery()
            ->from('AppUser')
            ->where($filter)
            ->orderBy($order);
        $oPager->setPage($page);
        $oPager->init();

        return $oPager;
     }
    
    /**
     * Check email repeated in DB
     *
     * @param string $email
     * @param integer $user_id
     * @return boolean
     */
    public function emailIsRepeated($email, $user_id)
    {
       $user_condition = $user_id ? ' AND id != '.$user_id : '';

       $q = Doctrine_Query::create()->from('AppUser')->where("email = '$email'".$user_condition);
       $d = $q->fetchOne();

       return $d ? true : false;
    }
    
   /**
    * Upload photo process
    *
    * @param array $file
    * @param mixed $recorded
    * @param boolean $reset
    */ 
    public function uploadPhoto($file, $recorded, $reset = false)
    {
          $destination = ServiceFileHandler::getUploadFolder('user');

          if ($file['size'] > 0)
          {
                  $f_extension = strtolower(strrchr($file['name'], '.'));
                          $upload_file = date('Y').'/'.uniqid('').$f_extension;

                          if (move_uploaded_file($file['tmp_name'], $destination.$upload_file)) {
                                  if ($recorded->getPhoto()) {
                                          @unlink($destination.$recorded->getPhoto());
                                          @unlink($destination.ServiceFileHandler::getThumbImage($recorded->getPhoto()));
                                  }
                                  @chmod($destination.$upload_file, 0777);
                                  $recorded->setPhoto($upload_file);

                                  ## Create thumbnail
                                  $oResize = new ResizeImage();
                                  $aThumbs = array(ServiceFileHandler::getThumbImage($upload_file) => array('w'=>20, 'h'=>20), $upload_file => array('w'=>150, 'h'=>150));
                                  $oResize->setMultiple($upload_file, $aThumbs, $destination, 0, 0, $f_extension, array('metodo' => 'full'));
                          }
          } 
          elseif ($reset && $recorded->getPhoto())
          {
                  @unlink($destination.$recorded->getPhoto());
                  @unlink($destination.ServiceFileHandler::getThumbImage($recorded->getPhoto()));

                  $recorded->setPhoto(NULL);
          }
          $recorded->save();
    }
    
    /**
     * Get array of all bedrooms for select tag
     *
     * @return array
     */
    public function getAllForSelectContact()
    {
           $i18N = sfContext::getInstance()->getI18N();
           $arr_options = array();
           
           $q = Doctrine_Query::create()
                   ->select('au.id AS id, au.name AS name, au.last_name AS last_name, ur.name AS rol')
                   ->from('AppUser au')
                   ->leftJoin('au.UserRole ur')
                   ->where('au.email IS NOT NULL')
                   ->andWhere('au.user_role_id = ?', 2)
                   ->orderBy(' id');
           
           $d = $q->fetchArray();
           
           foreach ($d as $value) {
                   $arr_options[$value['id']] = $value['name'].' '.$value['last_name'].' ('.$i18N->__($value['rol']).')';
           }
           return $arr_options;
    }
    
}