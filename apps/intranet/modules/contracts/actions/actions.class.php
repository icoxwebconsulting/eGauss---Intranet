<?php

/**
 * contracts actions.
 *
 * @package    sf_icox
 * @subpackage contracts
 * @author     Mauro 
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contractsActions extends sfActions
{
    /**
     * index
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
    {
        $temp_document = TempsDocumentsTable::getInstance()->findAll()->delete();
        
        $user_id = $this->getUser()->getAttribute('user_id');
        $string_contract = NULL;
        if(!$this->getUser()->hasCredential('super_admin')){
            if($this->getUser()->hasCredential('clientes')){
                $in_contarct = AppUserContractsIntermediationTable::getInstance()->findbyAppUserId($user_id);  
            }else{
                $company_in_user = AppUserRegisteredCompaniesTable::getInstance()->findByAppUser($user_id);
                $array_company_active = '(0,';
                foreach ($company_in_user AS $v)
                {
                    $array_company_active .= $v->getRegisteredCompaniesId().',';
                }
                $string_company = substr($array_company_active, 0, -1).')'; 

                $in_contarct = RegisteredCompaniesContractsIntermediationTable::getInstance()->getAllContractByCompany($string_company);  
            }


            $array_contract_active = '(0,';
            foreach ($in_contarct AS $v)
            {
                $array_contract_active .= $v->getContractsIntermediationId().',';
            }
            $string_contract = substr($array_contract_active, 0, -1).')'; 
        }
        
        $this->iPage  = $request->getParameter('page', 1);
        $this->oPager = ContractsIntermediationTable::getInstance()->getPager($this->iPage, 20, $this->setFilter(), $this->setOrderBy(), $string_contract);
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
                              0=>'--Seleccionar--',
                              1=>'Enero',
                              2=>'Febrero',
                              3=>'Marzo',
                              4=>'Abril',
                              5=>'Mayo',
                              6=>'Junio',
                              7=>'Julio',
                              8=>'Agosto',
                              9=>'Septiembre',
                              10=>'Octubre',
                              11=>'Noviembre',
                              12=>'Diciembre');

        $this->company      = RegisteredCompanies::getArrayForSelect(); 
        $this->sch_customer    = trim($this->getRequestParameter('sch_customer'));
        $this->sch_name    = trim($this->getRequestParameter('sch_name'));
        $this->sch_month       = trim($this->getRequestParameter('sch_month'));
        $this->sch_cashed      = trim($this->getRequestParameter('sch_cashed'));
        $this->sch_company  = trim($this->getRequestParameter('sch_company'));
       
        if (!empty($this->sch_customer)) {
                $sch_partial .= " AND (customer_name LIKE '%$this->sch_customer%')";
                $this->f_params .= '&sch_customer='.urlencode($this->sch_customer);
        }
        if (!empty($this->sch_name)) {
                $sch_partial .= " AND (name LIKE '%$this->sch_name%')";
                $this->f_params .= '&sch_name='.urlencode($this->sch_name);
        }
        if (!empty($this->sch_month)) {
                $sch_partial .= " AND month = '$this->sch_month'";
                $this->f_params .= '&sch_month='.urlencode($this->sch_month);
        }
        if (!empty($this->sch_cashed)) {
                $sch_partial .= " AND cashed = '$this->sch_cashed'";
                $this->f_params .= '&sch_cashed='.urlencode($this->sch_cashed);
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
          $q_order = $this->getRequestParameter('o', 'month');	// order
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
    public function executeRegister(sfWebRequest $request) { $this->forward('contracts', 'process'); }

   /**
    * Executes edit action
    *
    * @param sfWebRequest $request
    */
    public function executeEdit(sfWebRequest $request)
    {
  	if (!$request->getParameter('id')) {
  		$this->redirect('@contracts');
  	}
  	$this->forward('contracts', 'process');
    }
  
   /**
    * delete
    * @param sfWebRequest $request
    */
    public function executeDelete(sfWebRequest $request)
    {
      if (!$request->getParameter('id')) {
  		$this->redirect('@contracts');
      }
      $contracts = ContractsIntermediationTable::getInstance()->findOneById($request->getParameter('id'))->delete();
      
      $this->redirect('@contracts');
    }
    
   /**
    * Process form action
    *
    * @param sfWebRequest $request
    */
    public function executeProcess(sfWebRequest $request)
    {
        if(!$this->getUser()->hasCredential('super_admin')){
            $this->redirect('@contracts');
        }
        
        $this->id                  = $request->getParameter('id');
        $entity_object             = NULL;
        $this->error               = array();
        $this->error_calendar      = array();
        $this->company             = 1;
        $this->empresa             = 1;
        $this->url_document        = !$this->id ?'@contracts-register-document':'@contracts-register-document?id='.$this->id;
        $this->string_in_company   = '(0)';
        if ($this->id) {
              $entity_object = ContractsIntermediationTable::getInstance()->find($this->id);
              
              $company_in_contract = RegisteredCompaniesContractsIntermediationTable::getInstance()->findByContractsIntermediationId($this->id);
              
              $in_contract = '(0,';
              
              foreach ($company_in_contract as $v_company)
              {
                  $in_contract .= $v_company->getRegisteredCompaniesId().',';
              }    
              $this->string_in_company = substr($in_contract, 0, -1).')';
              
              if($entity_object->getRegisteredCompaniesId()){
                  $this->empresa = $entity_object->getRegisteredCompaniesId();
                  $this->company = 1;
              }else{
                  $this->company = 2;
              }
        }
        
        $this->form = new ContractsIntermediationForm($entity_object);
        $this->form->setDefault('date', "0000-00-0"); 
        
        
        if ($request->getMethod() == 'POST') {
              $this->company = $request->getParameter('company');
              $this->empresa = $request->getParameter('empresa');
              $this->form->bind($request->getParameter($this->form->getName()));
              if ($this->form->isValid() && count($this->error)== 0) 
              {
                $form_request = $request->getParameter($this->form->getName());

                $recorded = $this->form->save();

                $recorded->setDay(date('d'));
                $recorded->setMonth($form_request['month']);
                $recorded->setYear($form_request['year']);

                if($this->company==1){
                  $recorded->setRegisteredCompaniesId($this->empresa);    
                }else{
                  $recorded->setRegisteredCompaniesId(NULL);      
                }

                $recorded->setIsNew(1);
                $recorded->save();

                if($form_request['date']['year']!= ''){
                    
                    $hour_from = sprintf("%02d", $form_request['hour_from']['hour']).':'.sprintf("%02d", $form_request['hour_from']['minute']).':'.sprintf("%02d", $form_request['hour_from']['second']);
              
                    $hour_to   = sprintf("%02d", $form_request['hour_to']['hour']).':'.sprintf("%02d", $form_request['hour_to']['minute']).':'.sprintf("%02d", $form_request['hour_to']['second']);
                    
                    $day       = sprintf("%02d",$form_request['date']['day']).'/'.sprintf("%02d",$form_request['date']['month']).'/'.$form_request['date']['year'];
              
                    $event = CalendarTable::getInstance()->getAvailabilities($form_request['date']['year'], $form_request['date']['month'], $form_request['date']['day'], $hour_from, $this->id); 
              
                    if($event){
                      $this->error_calendar['event'] = 'Ya existe un Evento registrado para este horario: '.$hour_from.' -- '.$day;   
                    }

                    if($hour_from >= $hour_to)
                    {
                       $this->error_calendar['hour'] = 'El Horario de inicio debe ser anterior a Horario de fin'; 
                    }              
                    if(count($this->error_calendar)== 0){
                        $reunion = New Calendar();
                        $reunion->setYear($form_request['date']['year']);
                        $reunion->setMonth($form_request['date']['month']);
                        $reunion->setDay($form_request['date']['day']);  
                        $reunion->setHourFrom($hour_from);
                        $reunion->setHourTo($hour_to);
                        $reunion->setSubject($form_request['subject']);
                        $reunion->setBody($form_request['body']);
                        $reunion->setContractsIntermediationId($recorded->getId());
                        $reunion->setAppUserId($this->getUser()->getAttribute('user_id'));
                        $reunion->setTypeCalendarId(1);
                        $reunion->save();
                    }
                   
                }
                
                //set customer 
                AppUserContractsIntermediation::setCustomerInContract($recorded->getId(), $form_request['customer'], $this->id);
                
                //set company
                RegisteredCompaniesContractsIntermediation::setCompanyInContract($recorded->getId(), $form_request['company'], 'company', $this->id);
                
                //set affiliated
                RegisteredCompaniesContractsIntermediation::setCompanyInContract($recorded->getId(), $form_request['affiliated'], 'affiliated', $this->id);
                
                
                # set document
                $temp_document = TempsDocumentsTable::getInstance()->getFindAllByAppUser();

                if ($temp_document)
                {
                  foreach ($temp_document AS $v_doc)
                  {
                    $load_doc = NEW DocumentsRegisteredCompanies();
                    $load_doc->setName($v_doc->getName());
                    $load_doc->setIcon($v_doc->getIcon());
                    $load_doc->setDescription($v_doc->getDescription());
                    $load_doc->setDownload($v_doc->getDownload());
                    $load_doc->setUrl($v_doc->getUrl());
                    $load_doc->setContractsIntermediationId($recorded->getId());
                    $load_doc->save();

                    $v_doc->delete();
                  }
                }
                
                $products_array = $this->getUser()->getAttribute('product_temp', []);
                if(count($products_array)>0)
                {
                    foreach ($products_array AS $k=>$v_product){
                        $product_register = new ProductsContractsIntermediation();
                        $product_register->setProductsId($v_product['id_product']);
                        $product_register->setRegisteredCompaniesId($v_product['id_company']);
                        $product_register->setContractsIntermediationId($recorded->getId());
                        $product_register->setPercentage($v_product['percentage']);
                        $product_register->save();
                    }    
                }  
                $this->getUser()->getAttributeHolder()->remove('product_temp');
                
                if(!$this->id){
                  #set notification
                  Notifications::setNewNotification('contracts', 'Un nuevo Contratos de Intermediación fue creado', '', '', '', $recorded->getId());
                }

                $this->redirect('@contracts-edit?id='.$recorded->getId());
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
          
          $this->id      = $request->getParameter('id');
          if (empty($this->id)) { $this->redirect('@contracts'); }
          $this->oValue  = ContractsIntermediationTable::getInstance()->find($this->id);
          $this->month        = array(
                              1=>'Enero',
                              2=>'Febrero',
                              3=>'Marzo',
                              4=>'Abril',
                              5=>'Mayo',
                              6=>'Junio',
                              7=>'Julio',
                              8=>'Agosto',
                              9=>'Septiembre',
                              10=>'Octubre',
                              11=>'Noviembre',
                              12=>'Diciembre');

          $this->reunion_action = CalendarTable::getInstance()->findByContractsIntermediationId($this->id);
          $this->document       = DocumentsRegisteredCompaniesTable::getInstance()->getDocumentByContrat($this->id);
          $this->information    = InformationTable::getInstance()->findByContractsIntermediationId($this->id);  
          
          $this->customer       = AppUserContractsIntermediationTable::getInstance()->findByContractsIntermediationId($this->id); 
          $this->company        = RegisteredCompaniesContractsIntermediationTable::getInstance()->getAllCompanyAssociated($this->id, 'company'); 
          $this->affiliated     = RegisteredCompaniesContractsIntermediationTable::getInstance()->getAllCompanyAssociated($this->id, 'affiliated'); 
          $this->product        = ProductsContractsIntermediationTable::getInstance()->findByContractsIntermediationId($this->id); 
           
          
          if($this->oValue->getIsNew() == 1){$this->setTemplate('showNew');}
          
          
   }
   
   /**
    * contracts by month year
    * @param sfWebRequest $request
    */
    public function executeContractsByMonthYear(sfWebRequest $request)
    {
        $month_contracts = $request->getParameter('month_contracts', date('m'));
        $year_contracts  = $request->getParameter('year_contracts', date('Y'));
        $array_data = array('', 0, '', 0, '');
        
       
        $contracts = ContractsIntermediationTable::getInstance()->findByMonthAndYear($month_contracts, $year_contracts);
        
        if(count($contracts)>0)
        {   
            $index = 0;
            $array_data = array();
            foreach ($contracts AS $v_contract){
              $index++;  
              $array_data[$index][1] = $v_contract->getCustomer();
              $array_data[$index][2] = $v_contract->getBusinessAmount()?(double)$v_contract->getBusinessAmount():0;
              $array_data[$index][3] = '<div style="padding: 10px;">&nbsp;<b>Fecha de entrega:</b>&nbsp;'.sprintf("%02d",$v_contract->getDay()).'/'.sprintf("%02d",$v_contract->getMonth()).'/'.$v_contract->getYear().'&nbsp;<br/>&nbsp;<b>Cliente:</b>&nbsp;'.$v_contract->getCustomer().'&nbsp;<br/>&nbsp;<b>Volumen negocio:</b>&nbsp;'.($v_contract->getBusinessAmount()?$v_contract->getBusinessAmount():0).'</div>';
              $array_data[$index][4] = $v_contract->getFinalCommission()?(double)$v_contract->getFinalCommission():0;
              $array_data[$index][5] = '<div style="padding: 10px;">&nbsp;<b>Fecha de entrega:</b>&nbsp;'.sprintf("%02d",$v_contract->getDay()).'/'.sprintf("%02d",$v_contract->getMonth()).'/'.$v_contract->getYear().'&nbsp;<br/>&nbsp;<b>Socio:</b>&nbsp;'.$v_contract->getAppUser()->getTitle().' '.$v_contract->getAppUser()->getName().' '.$v_contract->getAppUser()->getLastName().'&nbsp;<br/>&nbsp;<b>Comisión final:</b>&nbsp;'.($v_contract->getFinalCommission()?$v_contract->getFinalCommission():0).'</div>';
              
            }
        }
        
        $date_1 = array($array_data[1][1],$array_data[1][2],$array_data[1][3],$array_data[1][4],$array_data[1][5]);
                  
        echo json_encode($date_1);
        exit();
    } 
    
    /**
     * delete reunion by contract
     * @param sfWebRequest $request
     */
    public function executeDeleteReunionByContract(sfWebRequest $request)
    {
        $id_reunion = $request->getParameter('id_reunion');
        
        $reunion = CalendarTable::getInstance()->findOneById($id_reunion);
        
        if($reunion){
            $reunion->delete();
        }
        
        return $this->renderComponent('contracts', 'getReunionByContract');
        
        exit();
    }
    
   /**
    * register document
    * @param sfWebRequest $request
    */
   public function executeRegisterDocument(sfWebRequest $request)
   {
      return $this->renderComponent('contracts', 'getDocument');
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
      
      return $this->renderComponent('contracts', 'getDocument');
      exit();
      
   }
   
   /**
    * register document
    * @param sfWebRequest $request
    */
   public function executeRegisterDocumentComment(sfWebRequest $request)
   {
      return $this->renderComponent('contracts', 'getDocumentComment');
      exit();
   }
  
   /**
    * Delete document
    * @param sfWebRequest $request
    */
   public function executeDeleteDocumentComment(sfWebRequest $request)
   {
      $id = $request->getParameter('id_doc');
      $type = $request->getParameter('type');
      $id_comment = $request->getParameter('id_comment', NULL);
      
      $redirect = $id_comment?'getDocumentViewComment':'getDocumentComment'; 
      
      if($type == 'real'){
          $d_document = DocumentsRegisteredCompaniesTable::getInstance()->findOneById($id);
      }else{
          $d_document = TempsDocumentsTable::getInstance()->findOneById($id);
      }
          
      if($d_document)
      {
          $d_document->delete();
      }    
      
      return $this->renderComponent('contracts', $redirect, array('id_comment'=>$id_comment));
      exit();
      
   }
   
   /**
    * contrat set commnet
    * @param sfWebRequest $request
    * @return componet
    */
   public function executeContratSetCommnet(sfWebRequest $request)
   {
      return $this->renderComponent('contracts', 'commentByContract');
      exit();
   }        
   
   /**
    * contrat delete commnet
    * @param sfWebRequest $request
    * @return componet
    */
   public function executeContratDeleteCommnet(sfWebRequest $request)
   {
       $id = $request->getParameter('id_comment');
       
       ContractsIntermediationCommentsTable::getInstance()->findOneById($id)->delete();
       
       return $this->renderComponent('contracts', 'commentByContract');
       exit();
       
   }      
   
   /**
    * SetTempProduct
    * @param sfWebRequest $request
    * @return type
    */
   public function executeSetTempProduct(sfWebRequest $request) {
       
       $product            = $request->getParameter('product');
       $percentage         = $request->getParameter('percentage');
       $string_in_company  = $request->getParameter('string_in_company');
        
       $product_temp = $this->getUser()->getAttribute('product_temp',[]);
       
       $product_object = ProductRegisteredCompaniesTable::getInstance()->findOneById($product);
       
       $array_tem      = ['id_product'=>$product_object->getProductsId(), 'id_company'=>$product_object->getRegisteredCompaniesId(), 'name'=>$product_object->getProducts()->getName().' - ('.$product_object->getRegisteredCompanies()->getName().')', 'percentage'=>$percentage, 'type'=>'temp'];
       
       $product_temp[] = $array_tem;
       
       $this->getUser()->setAttribute('product_temp', $product_temp);
       
       return $this->renderComponent('contracts', 'getProductByCompany', array('string_in_company'=>$string_in_company));
       exit();
   }
   
   /**
    * NewProductsByCompany
    * @param sfWebRequest $request
    * @return type
    */
   public function executeNewProductsByCompany(sfWebRequest $request)
   {
       $string_in_company  = $request->getParameter('string_in_company');
       
       return $this->renderComponent('contracts', 'getProductByCompany', array('string_in_company'=>$string_in_company));
       exit();
   }        
   
   /**
    * delete product
    * @param sfWebRequest $request
    * @return type
    */
   public function executeDeleteProduct(sfWebRequest $request)
   {
       $id_array           = $request->getParameter('id_array'); 
       $string_in_company  = $request->getParameter('string_in_company');
       $type               = $request->getParameter('type');
       
       $product_temp = $this->getUser()->getAttribute('product_temp',[]);
       
       if($type != 'temp')
       {
            ProductsContractsIntermediationTable::getInstance()->findOneById($id_array)->delete(); 
       } 
       else
       {
            unset($product_temp[$id_array]);
            $this->getUser()->setAttribute('product_temp', $product_temp);
       }    
       
       
       return $this->renderComponent('contracts', 'getProductByCompany', array('string_in_company'=>$string_in_company));
       exit();
   }        
}
?>