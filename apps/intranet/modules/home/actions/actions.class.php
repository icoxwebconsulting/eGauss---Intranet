<?php

/**
 * home actions.
 *
 * @package    sf_icox
 * @subpackage home
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{
   /**
    * Executes index action
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
        $this->getUser()->setCulture('es');
        
        if($this->getUser()->hasCredential('super_admin'))
        {
            $client = new Google_Client();
            $client->setClientId('394341489547.apps.googleusercontent.com');
            $client->setClientSecret('394341489547@developer.gserviceaccount.com');
            $client->setRedirectUri('http://egauss-intranet.icox.com');
            $client->setScopes(array('https://www.googleapis.com/auth/drive'));
            $client->setAccessType('online'); 

            $service = new Google_AnalyticsService($client);
            
            if ($request->getParameter('code')) {
                $this->getUser()->setAttribute('accessToken', $client->authenticate($request->getParameter('code')));
                $this->redirect('@homepage');
            } elseif (!$this->getUser()->getAttribute('accessToken')) {
                $client->authenticate();
            }
        }    

        $this->shareholders = CalendarTable::getInstance()->findOneByNextAndTypeCalendarId(1,2);
        $this->infomation   = InformationTable::getInstance()->getInformation();
        $this->notification = NotificationsTable::getInstance()->getNotifications($this->getUser()->getAttribute('user_id'));
        $this->calendar     = CalendarTable::getInstance()->getCalendarByUserAndDate($this->getUser()->getAttribute('user_id'), date('Y'), date('m'), date('d'));
    }
    
   /**
    * Executes logout action
    *
    * @param sfWebRequest $request
    */
   public function executeLogout(sfWebRequest $request)
   {  	
         ServiceAuthentication::closeSessionProcess();

         $this->redirect('@homepage');
   }
   
}
?>
