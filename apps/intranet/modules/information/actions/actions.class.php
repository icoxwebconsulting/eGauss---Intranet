<?php

/**
 * information actions.
 *
 * @package    sf_icox
 * @subpackage information
 * @author     Mauro 
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class informationActions extends sfActions
{
    /**
     * index
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->getUser()->getAttributeHolder()->remove('videos');
        $temp_document = TempsDocumentsTable::getInstance()->findAll()->delete();
        $this->iPage  = $request->getParameter('page', 1);
        $this->oPager = InformationTable::getInstance()->getPager($this->iPage, 20, $this->setFilter(), $this->setOrderBy());
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
        $this->f_params     = '';
        $sch_partial        = '1';
        $this->month        = array(
        											'-- Seleccionar --',
                              'Enero',
                              'Febrero',
                              'Marzo',
                              'Abril',
                              'Mayo',
                              'Junio',
                            	'Julio',
                              'Agosto',
                              'Septiembre',
                              'Octubre',
                              'Noviembre',
                              'Diciembre');

        $this->type         = TypeInformation::getArrayForSelect();
        $this->company      = RegisteredCompanies::getArrayForSelect(); 
        $this->sch_name    = trim($this->getRequestParameter('sch_name'));
        $this->sch_month    = trim($this->getRequestParameter('sch_month'));
        $this->sch_type     = trim($this->getRequestParameter('sch_type'));
        $this->sch_company  = trim($this->getRequestParameter('sch_company'));
        

        if (!empty($this->sch_name)) {
                $sch_partial .= " AND (name LIKE '%$this->sch_name%')";
                $this->f_params .= '&sch_name='.urlencode($this->sch_name);
        }
        if (!empty($this->sch_month)) {
                $first_day = date('Y').'-'.$this->sch_month.'-01';
                $end_day   = date('Y').'-'.$this->sch_month.'-31';
                $sch_partial .= " AND date > '$first_day' AND date < '$end_day'";
                $this->f_params .= '&sch_month='.urlencode($this->sch_month);
        }
        if (!empty($this->sch_type)) {
                $sch_partial .= " AND type_information_id = $this->sch_type";
                $this->f_params .= '&sch_type='.urlencode($this->sch_type);
        }
        if (!empty($this->sch_company)) {
                $sch_partial .= " AND registered_companies_id = $this->sch_company";
                $this->f_params .= '&sch_company='.urlencode($this->sch_company);
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
          $q_order = $this->getRequestParameter('o', 'name');	// order
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
    public function executeRegister(sfWebRequest $request) { $this->forward('information', 'process'); }

   /**
    * Executes edit action
    *
    * @param sfWebRequest $request
    */
    public function executeEdit(sfWebRequest $request)
    {
  	if (!$request->getParameter('id')) {
  		$this->redirect('@information');
  	}
  	$this->forward('information', 'process');
    }
  
   /**
    * delete
    * @param sfWebRequest $request
    */
    public function executeDelete(sfWebRequest $request)
    {
      if (!$request->getParameter('id')) {
  		$this->redirect('@information');
      }
      $videos      = VideosRegisteredCompaniesTable::getInstance()->findByInformationId($request->getParameter('id'))->delete();
      $document    = DocumentsRegisteredCompaniesTable::getInstance()->findByInformationId($request->getParameter('id'))->delete();
      
      $information = InformationTable::getInstance()->findOneById($request->getParameter('id'))->delete();
      
      $this->redirect('@information');
    }
    
   /**
    * Process form action
    *
    * @param sfWebRequest $request
    */
    public function executeProcess(sfWebRequest $request)
    {
        if(!$this->getUser()->hasCredential('super_admin')){
            $this->redirect('@information');
        }
        
        $this->id                  = $request->getParameter('id');
        $entity_object             = NULL;
        $this->url_register_videos = !$this->id?'@information-register-video':'@information-register-video?id='.$this->id;
        $this->url_get_videos      = !$this->id?'@information-get-components-videos':'@information-get-components-videos?id='.$this->id;
        $this->url_document        = !$this->id?'@information-register-document':'@information-register-document?id='.$this->id;
        $this->companies           = $request->getParameter('companies', 1);
        $this->contracts           = $request->getParameter('contracts', 0);
        if ($this->id) {
              $entity_object       = InformationTable::getInstance()->find($this->id);
              $this->companies     = $entity_object->getRegisteredCompaniesId()?1:0;
              $this->contracts     = $entity_object->getContractsIntermediationId()?1:0;
        }

        $this->form = new InformationForm($entity_object);
        
        if ($request->getMethod() == 'POST') {
              $this->form->bind($request->getParameter($this->form->getName()));
              if ($this->form->isValid()) 
              {
                  $this->companies           = $request->getParameter('companies');
                  $this->contracts           = $request->getParameter('contracts');
                  $recorded = $this->form->save();
                  
                  if($this->companies){$recorded->setContractsIntermediationId(NULL);}
                  if($this->contracts){$recorded->setRegisteredCompaniesId(NULL);}
                  
                  $recorded->save();
                  
                  if($recorded->getRegisteredCompaniesId())
                  {
                      $company_id_user = $recorded->getRegisteredCompaniesId();
                      $title = 'empresa';
                      $title_mail = 'Empresa Participada';
                      $name_company = $recorded->getRegisteredCompanies()->getName();
                  } 
                  else
                  {
                      $contract_intermediation = ContractsIntermediationTable::getInstance()->findOneById($recorded->getContractsIntermediationId());
                      $company_id_user         = $contract_intermediation->getRegisteredCompaniesId();
                      $title = 'intermediación';
                      $title_mail = 'Intermediación';
                      $name_company = $contract_intermediation->getName();
                  }    
                  
                  if($recorded->getRegisteredCompaniesId()){
                    $app_user = AppUserRegisteredCompaniesTable::getInstance()->findByRegisteredCompaniesId($company_id_user);
                  }else{
                    $company_in_contarct = RegisteredCompaniesContractsIntermediationTable::getInstance()->findbyContractsIntermediationId($recorded->getContractsIntermediationId());
                    
                    $array_company_active = '(0,';
                    foreach ($company_in_contarct AS $v)
                    {
                        $array_customer_active .= $v->getRegisteredCompaniesId().',';
                    }
                    $string_customer = substr($array_company_active, 0, -1).')';
                    
                    $app_user = AppUserRegisteredCompaniesTable::getInstance()->getAppUserByCompanys($string_customer);  
                  }
                      
                  if($app_user)
                  {    
                    foreach ($app_user AS $value){
                      $notification_user = NotificationsTable::getInstance()->findOneByInformationIdAndAppUserId($recorded->getId(), $value->getAppUserId());
                      if(!$notification_user){
                          Notifications::setNewNotification('information', 'Una nueva información de la '.$title.': '.$name_company.' se ha registrado','',$value->getAppUserId(), $recorded->getId());   
                      }
                    }  
                  }  

                  if($recorded->getImportant())
                  {
                      if($app_user)
                      {    
                        sfProjectConfiguration::getActive()->loadHelpers(array("Url")); 
                        foreach ($app_user AS $value){
                          $sendEmail = ServiceOutgoingMessages::sendToSingleAccount
                            (
                              $value->getAppUser()->getTitle().' '.$value->getAppUser()->getName().' '.$value->getAppUser()->getLastName(), $value->getAppUser()->getEmail(),
                              'home/companyInformation',
                              array(
                                'subject'    => 'eGauss.com Noticias de '.$title_mail,
                                'to_partial' => array(
                                  'name_user'    => $value->getAppUser()->getTitle().' '.$value->getAppUser()->getName().' '.$value->getAppUser()->getLastName(),
                                  'name_company' => $recorded->getRegisteredCompanies()->getName(),
                                  'name_info'    => $recorded->getName(),
                                  'type'         => $recorded->getTypeInformation()->getName(),
                                  'content'      => $recorded->getDescription(),
                                  'url'          => url_for('@information-show?id='.$recorded->getId(),true),
                                  'url_home'     => url_for('@homepage',true)
                                )
                              )
                            );         
                      }  
                  }  
                      
                  }    
                  #set videos
                  if($new_videos = $this->getUser()->getAttribute('videos'))
                  {
                      foreach ($new_videos as $k=>$value)
                      {
                          $load_videos = new VideosRegisteredCompanies();
                          $load_videos->setName($value['name']);
                          $load_videos->setUrl($value['url']);
                          $load_videos->setRegisteredCompaniesId($recorded->getRegisteredCompaniesId());
                          $load_videos->setInformationId($recorded->getId());
                          $load_videos->save();
                      }  
                      $this->getUser()->getAttributeHolder()->remove('videos');
                  }

                  #set document
                  $temp_document = TempsDocumentsTable::getInstance()->getFindAllByAppUser();
                  if($temp_document)
                  {
                      foreach ($temp_document AS $v_doc)
                      {
                          $load_doc = NEW DocumentsRegisteredCompanies();
                          $load_doc->setName($v_doc->getName());
                          $load_doc->setIcon($v_doc->getIcon());
                          $load_doc->setDescription($v_doc->getDescription());
                          $load_doc->setDownload($v_doc->getDownload());
                          $load_doc->setUrl($v_doc->getUrl());
                          if($recorded->getRegisteredCompaniesId())
                          {    
                            $load_doc->setRegisteredCompaniesId($recorded->getRegisteredCompaniesId());
                          }
                          if($recorded->getContractsIntermediationId())
                          {    
                            $load_doc->setContractsIntermediationId($recorded->getContractsIntermediationId());
                          }
                          $load_doc->setInformationId($recorded->getId());
                          $load_doc->setTypeInformationId($recorded->getTypeInformationId());
                          $load_doc->save();

                          $v_doc->delete();
                      }
                  }

                  $this->redirect('@information-edit?id='.$recorded->getId());
              }
        }

        $this->setTemplate('form');
    }
  
   /**
    * register video
    * @param sfWebRequest $request
    */
    public function executeRegisterVideo(sfWebRequest $request)
    {
        $this->error      = array();
        $this->name       = $request->getParameter('name','');
        $this->url        = $request->getParameter('url','');
        $this->msj_ok     = false;
        $array_videos_new = array();
        $array_videos     = $this->getUser()->getAttribute('videos', array());

        if($request->isMethod('POST'))
        {          
            if($this->name == ''){$this->error['name']='Ingrese el nombre';}    
            if($this->url == ''){$this->error['url']='Ingrese la url';}  

            if(count($this->error)== 0)
            {
                $array_videos_new[] = array(
                                      'name' => $this->name, 
                                      'url'  => $this->url,
                                      'type' => 'temp'
                                  );

                $new_videos_array = array_merge($array_videos,$array_videos_new);
                $this->getUser()->setAttribute('videos', $new_videos_array);
                $this->name = '';
                $this->url  ='';
                $this->msj_ok = true;
            }    
      }    
      
      $this->setLayout('layout_iframe');
    }
  
   /**
    * get components videos
    * @param sfWebRequest $request
    */
    public function executeGetComponentsVideos(sfWebRequest $request)
    {
        return $this->renderComponent('information', 'getVideos');
        exit();
    }      
  
   /**
    * Delete Video
    * @param sfWebRequest $request
    */
    public function executeDeleteVideo(sfWebRequest $request)
    {
        $id           = $request->getParameter('id_video');
        $array_videos = $this->getUser()->getAttribute('videos',array());
        $type         = $request->getParameter('type');

        if($type == 'real')
        {
            $d_videos = VideosRegisteredCompaniesTable::getInstance()->findOneById($id)->delete();
        }
        else
        {    
          unset($array_videos[$id]);
        }  

        $this->getUser()->setAttribute('videos', $array_videos);

        return $this->renderComponent('information', 'getVideos');
        exit();
      
    }
  
   /**
    * register document
    * @param sfWebRequest $request
    */
    public function executeRegisterDocument(sfWebRequest $request)
    {
        return $this->renderComponent('information', 'getDocument');
        exit();
    }
  
   /**
    * Delete document
    * @param sfWebRequest $request
    */
    public function executeDeleteDocument(sfWebRequest $request)
    {
        $id = $request->getParameter('id_doc');
        $type = $request->getParameter('type');

        if($type == 'real'){
            $d_document = DocumentsRegisteredCompaniesTable::getInstance()->findOneById($id);
        }else{
            $d_document = TempsDocumentsTable::getInstance()->findOneById($id);
        }

        if($d_document)
        {
            $d_document->delete();
        }    

        return $this->renderComponent('information', 'getDocument');
        exit();
      
    }
    
    /**
     * Executes show action
     *
     * @param sfWebRequest $request
     */
    public function executeShow(sfWebRequest $request)
    {
          
          $this->id      = $request->getParameter('id');
          $this->oValue  = InformationTable::getInstance()->find($this->id);
          $this->company = $this->oValue->getRegisteredCompanies();
          $this->logo    = $this->company->getLogo();
          $this->is_iframe = trim($this->getRequestParameter('iframe', NULL));

          if (empty($this->id)) { $this->redirect('@information'); }
          if($this->is_iframe){$this->setLayout('layout_iframe');}
    }
}
?>