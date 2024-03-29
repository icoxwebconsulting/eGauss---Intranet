<?php

/**
 * VideosRegisteredCompanies form base class.
 *
 * @method VideosRegisteredCompanies getObject() Returns the current form's model object
 *
 * @package    egauss
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVideosRegisteredCompaniesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'name'                    => new sfWidgetFormInputText(),
      'url'                     => new sfWidgetFormInputText(),
      'registered_companies_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RegisteredCompanies'), 'add_empty' => false)),
      'information_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Information'), 'add_empty' => true)),
      'entrepreneur_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entrepreneur'), 'add_empty' => true)),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                    => new sfValidatorString(array('max_length' => 50)),
      'url'                     => new sfValidatorString(array('max_length' => 200)),
      'registered_companies_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RegisteredCompanies'))),
      'information_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Information'), 'required' => false)),
      'entrepreneur_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entrepreneur'), 'required' => false)),
      'created_at'              => new sfValidatorDateTime(),
      'updated_at'              => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('videos_registered_companies[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VideosRegisteredCompanies';
  }

}
