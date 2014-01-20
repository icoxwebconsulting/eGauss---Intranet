<?php

/**
 * BaseTypeCompanies
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $TypeCompanies
 * 
 * @method integer             getId()            Returns the current record's "id" value
 * @method string              getName()          Returns the current record's "name" value
 * @method Doctrine_Collection getTypeCompanies() Returns the current record's "TypeCompanies" collection
 * @method TypeCompanies       setId()            Sets the current record's "id" value
 * @method TypeCompanies       setName()          Sets the current record's "name" value
 * @method TypeCompanies       setTypeCompanies() Sets the current record's "TypeCompanies" collection
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTypeCompanies extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('type_companies');
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

        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('RegisteredCompanies as TypeCompanies', array(
             'local' => 'id',
             'foreign' => 'type_companies_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}