<?php

/**
 * user actions.
 *
 * @package    sf_icox
 * @subpackage user
 * @author     pinika
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->iPage  = $request->getParameter('page', 1);
  	$this->oPager = AppUserTable::getInstance()->getPager($this->iPage, 20, $this->setFilter(), $this->setOrderBy());
  	$this->oList  = $this->oPager->getResults();
    $this->oCant  = $this->oPager->getNbResults();
  }

  /**
   * Set filter
   *
   * @return string
   */
  protected function setFilter()
  {
    $sessionUser = sfContext::getInstance()->getUser();
    
    $i18N        = sfContext::getInstance()->getI18N();
    
    $rols = '(1,2,3,4)';
    $rols = $sessionUser->getAttribute('user_role') == 'socios'?'(0,2)':$rols;
    
    $this->choices_array= array(0=>$i18N->__('Select', NULL, 'messages'),1=>$i18N->__('Super Admin', NULL, 'messages'),2=>$i18N->__('Socio', NULL, 'messages'), 3=>$i18N->__('Clientes', NULL, 'messages'), 4=>$i18N->__('Socios Empresa', NULL, 'messages')); 
    
    $sch_partial = 'id != '.$sessionUser->getAttribute('user_id'). ' AND user_role_id IN '.$rols;

    $this->f_params  = '';
    $this->sch_name  = trim($this->getRequestParameter('sch_name'));
    $this->sch_email = trim($this->getRequestParameter('sch_email'));
    $this->sch_rol   = trim($this->getRequestParameter('sch_rol'));

    if (!empty($this->sch_name))
    {
      $sch_partial .= " AND (name LIKE '%$this->sch_name%' OR last_name LIKE '%$this->sch_name%')";
      $this->f_params .= '&sch_name='.urlencode($this->sch_name);
    }
    if (!empty($this->sch_email))
    {
      $sch_partial .= " AND email LIKE '%$this->sch_email%'";
      $this->f_params .= '&sch_email='.urlencode($this->sch_email);
    }
    if (!empty($this->sch_rol))
    {
      $sch_partial .= " AND user_role_id = '$this->sch_rol'";
      $this->f_params .= '&sch_rol='.urlencode($this->sch_rol);
    }
    return $sch_partial;
  }

  /**
   * Set list order
   *
   * @return string
   */
  protected function setOrderBy()
  {
  	$q_order = $this->getRequestParameter('o', 'user_role_id');	// order
  	$q_sort  = $this->getRequestParameter('s', 'asc');  // sort

  	$this->sort = $q_sort == 'asc' ? 'desc' : 'asc';
  	$this->pager_order = "&o=$q_order&s=$q_sort";

  	return "$q_order $q_sort";
  }

  /**
   * Executes create action
   *
   * @param sfWebRequest $request
   */
  public function executeRegister(sfWebRequest $request) { $this->forward('user', 'process'); }

  /**
	 * Executes edit action
	 *
	 * @param sfWebRequest $request
	 */
  public function executeEdit(sfWebRequest $request)
  {
  	if (!$request->getParameter('id')) {
  		$this->redirect('@user');
  	}
  	$this->forward('user', 'process');
  }
  
  /**
   * Process form action
   *
   * @param sfWebRequest $request
   */
  public function executeProcess(sfWebRequest $request)
  {
        
  	$this->id         = $request->getParameter('id');
        $this->my_profile = $request->getParameter('profile', NULL);
        $this->my_go_ok   = false;
  	$this->email      = '';
  	$this->phone      = '';
        $this->skype      = '';
  	$this->basecamp   = array();
  	$this->error      = array();
  	$this->photo      = NULL;
  	$entity_object    = NULL;
  	$send_password    = false;

        if($this->my_profile){
            if($this->id != $this->getUser()->getAttribute('user_id')){
                    $this->redirect('@homepage');	
            }
	}else{
            if(!$this->getUser()->hasCredential('super_admin')){
                    $this->redirect('@user');
            }
	}
        
  	if ($this->id)
  	{
            $entity_object  = AppUserTable::getInstance()->find($this->id);
            $this->basecamp = AppUserTable::getInstance()->getRelEnBasecamp($this->id);
            $this->email    = $entity_object->getEmail();
            $this->phone    = $entity_object->getPhone();
            $this->skype    = $entity_object->getSkype();
            $this->photo    = $entity_object->getPhoto();
  	}
  	$this->form = new UserRolForm($entity_object);
        
        if ($this->id)
        {
          $this->form->setDefault('contact_time_from', $entity_object->getContactTimeFrom()); 
          $this->form->setDefault('contact_time_to', $entity_object->getContactTimeTo());
        }
        
  	if ($request->getMethod() == 'POST')
  	{
  		$this->basecamp = $request->getParameter('proyectos', array());
  		$this->email = trim($request->getParameter('email'));
  		$this->phone = trim($request->getParameter('phone'));
                $this->skype = trim($request->getParameter('skype'));

  		$x_password  = trim($request->getParameter('password'));
  		$r_password  = trim($request->getParameter('repeat_password'));

  		## check values
  		$check_email = AppUser::checkProfileEmail($this->email, $this->id);
  		$check_password = AppUser::checkProfilePassword($x_password, $r_password, $this->id);

  		if (!empty($check_email))    { $this->error['email'] = $check_email; }
  		if (!empty($check_password)) { $this->error['password'] = $check_password; }

  		$form_request = $request->getParameter($this->form->getName());
                $form_request['company_id'] = 1;
                $form_request['email']      = $this->email;
                $form_request['phone']      = $this->phone;
                $form_request['skype']      = $this->skype;

                $this->form->bind($form_request);

                ## continue
                if ($this->form->isValid() && !$this->error) 
                {
                    $recorded = $this->form->    save();

                    $recorded->setContactTimeFrom(
                            sprintf("%02d", $form_request['contact_time_from']['hour']).':'.
                            sprintf("%02d", $form_request['contact_time_from']['minute']).':'.
                            sprintf("%02d", $form_request['contact_time_from']['second'])
                    );
                    $recorded->setContactTimeTo(
                            sprintf("%02d", $form_request['contact_time_to']['hour']).':'.
                            sprintf("%02d", $form_request['contact_time_to']['minute']).':'.
                            sprintf("%02d", $form_request['contact_time_to']['second'])
                    );
                    $recorded->save();
                        
                    ## set password
                    if (!empty($x_password))
                    {
                            $recorded->setPassword($x_password);
                            $send_password = true;
                    }
                    ## set photo
                    AppUserTable::getInstance()->uploadPhoto($request->getFiles('photo'), $recorded, $request->getParameter('reset_photo'));

                    ## send password to user
                    if ($send_password) { AppUser::sendPasswordToUser($x_password, $this->email, $recorded->getName().' '.$recorded->getLastName()); }

                    if (!$this->my_profile)
                    {
                        ## set proyectos basecamp
                        AppUserTable::getInstance()->setRelEnBasecamp($recorded->getId(), $this->basecamp, $request->getParameter('auxi_lista', array()));

                        $this->redirect('@user-show?id='.$recorded->getId());
                    }
                    else 
                    {
                      ## update session user data
                      $this->getUser()->setAttribute('user_name', $recorded->getName());
                      $this->getUser()->setAttribute('user_photo', $recorded->getPhoto());

                      $this->my_go_ok = true;
                    }
                }
        }
        $this->setTemplate('form');
  }

  /**
   * Executes show action
   *
   * @param sfWebRequest $request
   */
  public function executeShow(sfWebRequest $request)
  {
  	$this->id = $request->getParameter('id');
  	$this->oValue = AppUserTable::getInstance()->find($this->id);

  	if (empty($this->id)) { $this->redirect('@user'); }
  }
  
  /**
   * Executes view action
   *
   * @param sfWebRequest $request
   */
  public function executeViewUser(sfWebRequest $request)
  {
  	$this->id = $request->getParameter('id');
  	$this->oValue = AppUserTable::getInstance()->find($this->id);

  	if (empty($this->id)) { $this->redirect('@user'); }
        
    $this->setLayout('layout_iframe');
  }

  /**
   * Executes delete action
   *
   * @param sfWebRequest $request
   */
  public function executeDelete(sfWebRequest $request)
  {
  	$oValue = AppUserTable::getInstance()->find($request->getParameter('id'));

  	if ($oValue) {
  		if (AppUser::isClearToContinue($oValue)) {
  			## delete photo
	  		$destination = ServiceFileHandler::getUploadFolder('user');

	  		@unlink($destination.$oValue->getPhoto());
				@unlink($destination.ServiceFileHandler::getThumbImage($oValue->getPhoto()));

				## delete user
	  		$oValue->delete();
  		}
  	}
  	$this->redirect('@user');
  }

} // end class