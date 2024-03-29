<?php

/**
 * BaseNotifications
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $registered_companies_id
 * @property integer $information_id
 * @property integer $contracts_intermediation_id
 * @property integer $app_user_id
 * @property string $type
 * @property text $subject
 * @property boolean $important
 * @property RegisteredCompanies $RegisteredCompanies
 * @property Information $Information
 * @property ContractsIntermediation $ContractsIntermediation
 * @property AppUser $AppUser
 * 
 * @method integer                 getId()                          Returns the current record's "id" value
 * @method integer                 getRegisteredCompaniesId()       Returns the current record's "registered_companies_id" value
 * @method integer                 getInformationId()               Returns the current record's "information_id" value
 * @method integer                 getContractsIntermediationId()   Returns the current record's "contracts_intermediation_id" value
 * @method integer                 getAppUserId()                   Returns the current record's "app_user_id" value
 * @method string                  getType()                        Returns the current record's "type" value
 * @method text                    getSubject()                     Returns the current record's "subject" value
 * @method boolean                 getImportant()                   Returns the current record's "important" value
 * @method RegisteredCompanies     getRegisteredCompanies()         Returns the current record's "RegisteredCompanies" value
 * @method Information             getInformation()                 Returns the current record's "Information" value
 * @method ContractsIntermediation getContractsIntermediation()     Returns the current record's "ContractsIntermediation" value
 * @method AppUser                 getAppUser()                     Returns the current record's "AppUser" value
 * @method Notifications           setId()                          Sets the current record's "id" value
 * @method Notifications           setRegisteredCompaniesId()       Sets the current record's "registered_companies_id" value
 * @method Notifications           setInformationId()               Sets the current record's "information_id" value
 * @method Notifications           setContractsIntermediationId()   Sets the current record's "contracts_intermediation_id" value
 * @method Notifications           setAppUserId()                   Sets the current record's "app_user_id" value
 * @method Notifications           setType()                        Sets the current record's "type" value
 * @method Notifications           setSubject()                     Sets the current record's "subject" value
 * @method Notifications           setImportant()                   Sets the current record's "important" value
 * @method Notifications           setRegisteredCompanies()         Sets the current record's "RegisteredCompanies" value
 * @method Notifications           setInformation()                 Sets the current record's "Information" value
 * @method Notifications           setContractsIntermediation()     Sets the current record's "ContractsIntermediation" value
 * @method Notifications           setAppUser()                     Sets the current record's "AppUser" value
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNotifications extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('notifications');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('registered_companies_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('information_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('contracts_intermediation_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('app_user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('type', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('subject', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('important', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));

        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('RegisteredCompanies', array(
             'local' => 'registered_companies_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Information', array(
             'local' => 'information_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasOne('ContractsIntermediation', array(
             'local' => 'contracts_intermediation_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasOne('AppUser', array(
             'local' => 'app_user_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}