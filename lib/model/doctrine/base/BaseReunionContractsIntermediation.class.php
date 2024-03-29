<?php

/**
 * BaseReunionContractsIntermediation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property datetime $date
 * @property text $comments
 * @property integer $contracts_intermediation_id
 * @property ContractsIntermediation $ContractsIntermediation
 * 
 * @method integer                        getId()                          Returns the current record's "id" value
 * @method datetime                       getDate()                        Returns the current record's "date" value
 * @method text                           getComments()                    Returns the current record's "comments" value
 * @method integer                        getContractsIntermediationId()   Returns the current record's "contracts_intermediation_id" value
 * @method ContractsIntermediation        getContractsIntermediation()     Returns the current record's "ContractsIntermediation" value
 * @method ReunionContractsIntermediation setId()                          Sets the current record's "id" value
 * @method ReunionContractsIntermediation setDate()                        Sets the current record's "date" value
 * @method ReunionContractsIntermediation setComments()                    Sets the current record's "comments" value
 * @method ReunionContractsIntermediation setContractsIntermediationId()   Sets the current record's "contracts_intermediation_id" value
 * @method ReunionContractsIntermediation setContractsIntermediation()     Sets the current record's "ContractsIntermediation" value
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReunionContractsIntermediation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('reunion_contracts_intermediation');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('date', 'datetime', null, array(
             'type' => 'datetime',
             'notnull' => true,
             ));
        $this->hasColumn('comments', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('contracts_intermediation_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));

        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ContractsIntermediation', array(
             'local' => 'contracts_intermediation_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}