<?php

/**
 * RegisteredCompanies form.
 *
 * @package    egauss
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RegisteredCompaniesForm extends BaseRegisteredCompaniesForm
{
  public function configure()
  {
    $i18N       = sfContext::getInstance()->getI18N(); 
    $id_contac  = $this->getOption('module') == 'affiliated'?2:4;
    $contact    = AppUserTable::getInstance()->getAllForSelectContact($id_contac);
    $product    = Products::getArrayForSelect();
    $valida_contact = AppUserTable::getInstance()->getAllForSelect();
    $id         = $this->getObject()->getId();
    $associated = array();
    $associated_product = array();
    $required_contacts = FALSE;
    
    if ($id)
    {
      $associated         = AppUserRegisteredCompaniesTable::getInstance()->getAllForSelectContactAssociated($id);
      $associated_product = ProductRegisteredCompaniesTable::getInstance()->getAllForSelectProductAssociated($id);
    }  
    if ($this->getOption('module') == 'affiliated' || $this->getOption('module') == 'company')
    {
       $required_contacts = $i18N->__('Enter the contact', NULL, 'errors');
    }
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'date'               => new sfWidgetFormJQueryDate(array('image'=>'/images/calendario.gif','date_widget' => new sfWidgetFormDate(array('format' => '%day% %month% %year%')))),
      'name'               => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'description'        => new sfWidgetFormTextareaTinyMCE(array('config' =>'theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,forecolor,backcolor",theme_advanced_buttons3 : "removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr",'),array('style' => 'width:930px;  height: 450px;', 'rows' => 10, 'class' => 'foo')),
      'email'              => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'address'            => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'phone'              => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'skype'              => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'website'            => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'contact_first_name' => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'contact_last_name'  => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'contact_phone'      => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'contact_email'      => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'basecamp_id'        => new sfWidgetFormInputText(array(), array('class'=>'form_input', 'style'=>'width:300px;')),
      'type_companies_id'  => new sfWidgetFormInputHidden(),
      'comments'           => new sfWidgetFormTextareaTinyMCE(array('config' => 'theme_advanced_buttons1 : "cut, copy, paste, images, bold, italic, underline, justifyleft, justifycenter, justifyright , outdent, indent, bullist, numlist, undo, redo, link",theme_advanced_buttons2 : "",theme_advanced_buttons3 : ""'),array('style' => 'width:900px;  height: 150px;', 'rows' => 10, 'class' => 'foo')),
      'contacts'           => new sfWidgetFormChoice(array('choices'=> $contact,'renderer_class' => 'sfWidgetFormSelectDoubleList','renderer_options'=>array('associated_first'=>FALSE,'associated_choices' => $associated, 'label_unassociated'=>$i18N->__('Unassociated'), 'label_associated'=>$i18N->__('Associated')))),
      'product'            => new sfWidgetFormChoice(array('choices'=> $product,'renderer_class' => 'sfWidgetFormSelectDoubleList','renderer_options'=>array('associated_first'=>FALSE,'associated_choices' => $associated_product, 'label_unassociated'=>$i18N->__('Unassociated'), 'label_associated'=>$i18N->__('Associated'))))  
    ));
    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date'               => new sfValidatorDate(array('required' => true), array('required' => 'La fecha es obligatoria', 'invalid' => 'La fecha ingresada es incorrecta')),
      'name'               => new sfValidatorString(array('max_length' => 50), array('required'=>$i18N->__('Enter the name', NULL, 'errors'))),
      'description'        => new sfValidatorPass(array('required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'address'            => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'phone'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'skype'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'website'            => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'contact_first_name' => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'contact_last_name'  => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'contact_phone'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'contact_email'      => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'basecamp_id'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),  
      'type_companies_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TypeCompanies'))),
      'comments'           => new sfValidatorPass(array('required' => false)),
      'contacts'           => new sfValidatorChoice(array('choices' => array_keys($valida_contact), 'multiple' => true, 'required'=>$required_contacts ),array('required'=>$required_contacts)),  
      'product'            => new sfValidatorChoice(array('choices' => array_keys($product), 'multiple' => true, 'required'=>FALSE ))    
    ));
    
    switch ($this->getOption('module')) {
        case 'affiliated':
            $this->setDefault('type_companies_id', 1);
            break;
        case 'analyzed':
            $this->setDefault('type_companies_id', 2);
            break;
        case 'company':
            $this->setDefault('type_companies_id', 3);
            break;
    }
    
    $this->widgetSchema->setNameFormat('registered_companies[%s]');
  }

} // end class