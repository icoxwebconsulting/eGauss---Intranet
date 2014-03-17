<?php

/**
 * BaseTempsDocuments
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property text $description
 * @property string $icon
 * @property string $url
 * @property string $download
 * @property integer $type_information_id
 * @property TypeInformation $TypeInformation
 * 
 * @method integer         getId()                  Returns the current record's "id" value
 * @method string          getName()                Returns the current record's "name" value
 * @method text            getDescription()         Returns the current record's "description" value
 * @method string          getIcon()                Returns the current record's "icon" value
 * @method string          getUrl()                 Returns the current record's "url" value
 * @method string          getDownload()            Returns the current record's "download" value
 * @method integer         getTypeInformationId()   Returns the current record's "type_information_id" value
 * @method TypeInformation getTypeInformation()     Returns the current record's "TypeInformation" value
 * @method TempsDocuments  setId()                  Sets the current record's "id" value
 * @method TempsDocuments  setName()                Sets the current record's "name" value
 * @method TempsDocuments  setDescription()         Sets the current record's "description" value
 * @method TempsDocuments  setIcon()                Sets the current record's "icon" value
 * @method TempsDocuments  setUrl()                 Sets the current record's "url" value
 * @method TempsDocuments  setDownload()            Sets the current record's "download" value
 * @method TempsDocuments  setTypeInformationId()   Sets the current record's "type_information_id" value
 * @method TempsDocuments  setTypeInformation()     Sets the current record's "TypeInformation" value
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTempsDocuments extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('temps_documents');
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
        $this->hasColumn('description', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('icon', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
        $this->hasColumn('url', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
        $this->hasColumn('download', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
        $this->hasColumn('type_information_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));

        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('TypeInformation', array(
             'local' => 'type_information_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}