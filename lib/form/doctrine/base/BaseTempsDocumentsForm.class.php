<?php

/**
 * TempsDocuments form base class.
 *
 * @method TempsDocuments getObject() Returns the current form's model object
 *
 * @package    egauss
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTempsDocumentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'name'                => new sfWidgetFormInputText(),
      'description'         => new sfWidgetFormInputText(),
      'icon'                => new sfWidgetFormInputText(),
      'url'                 => new sfWidgetFormInputText(),
      'download'            => new sfWidgetFormInputText(),
      'type_information_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TypeInformation'), 'add_empty' => true)),
      'app_user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AppUser'), 'add_empty' => true)),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 50)),
      'description'         => new sfValidatorPass(array('required' => false)),
      'icon'                => new sfValidatorString(array('max_length' => 200)),
      'url'                 => new sfValidatorString(array('max_length' => 200)),
      'download'            => new sfValidatorString(array('max_length' => 200)),
      'type_information_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TypeInformation'), 'required' => false)),
      'app_user_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AppUser'), 'required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('temps_documents[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TempsDocuments';
  }

}
