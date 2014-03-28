<?php

/**
 * BaseVideosRegisteredCompanies
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $registered_companies_id
 * @property integer $information_id
 * @property integer $entrepreneur_id
 * @property RegisteredCompanies $RegisteredCompanies
 * @property Information $Information
 * @property Entrepreneur $Entrepreneur
 * 
 * @method integer                   getId()                      Returns the current record's "id" value
 * @method string                    getName()                    Returns the current record's "name" value
 * @method string                    getUrl()                     Returns the current record's "url" value
 * @method integer                   getRegisteredCompaniesId()   Returns the current record's "registered_companies_id" value
 * @method integer                   getInformationId()           Returns the current record's "information_id" value
 * @method integer                   getEntrepreneurId()          Returns the current record's "entrepreneur_id" value
 * @method RegisteredCompanies       getRegisteredCompanies()     Returns the current record's "RegisteredCompanies" value
 * @method Information               getInformation()             Returns the current record's "Information" value
 * @method Entrepreneur              getEntrepreneur()            Returns the current record's "Entrepreneur" value
 * @method VideosRegisteredCompanies setId()                      Sets the current record's "id" value
 * @method VideosRegisteredCompanies setName()                    Sets the current record's "name" value
 * @method VideosRegisteredCompanies setUrl()                     Sets the current record's "url" value
 * @method VideosRegisteredCompanies setRegisteredCompaniesId()   Sets the current record's "registered_companies_id" value
 * @method VideosRegisteredCompanies setInformationId()           Sets the current record's "information_id" value
 * @method VideosRegisteredCompanies setEntrepreneurId()          Sets the current record's "entrepreneur_id" value
 * @method VideosRegisteredCompanies setRegisteredCompanies()     Sets the current record's "RegisteredCompanies" value
 * @method VideosRegisteredCompanies setInformation()             Sets the current record's "Information" value
 * @method VideosRegisteredCompanies setEntrepreneur()            Sets the current record's "Entrepreneur" value
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseVideosRegisteredCompanies extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('videos_registered_companies');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('url', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
        $this->hasColumn('registered_companies_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('information_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('entrepreneur_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
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

        $this->hasOne('Entrepreneur', array(
             'local' => 'entrepreneur_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}