<?php

/**
 * BaseBilling
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $year
 * @property integer $month
 * @property decimal $total_affiliated
 * @property decimal $sale_of_affiliated
 * @property decimal $total_consultancy
 * @property decimal $consultancy
 * @property decimal $total_intermediation
 * @property decimal $intermediation
 * @property decimal $total_formation
 * @property decimal $formation
 * @property decimal $total_patents
 * @property decimal $patents
 * 
 * @method integer getId()                   Returns the current record's "id" value
 * @method integer getYear()                 Returns the current record's "year" value
 * @method integer getMonth()                Returns the current record's "month" value
 * @method decimal getTotalAffiliated()      Returns the current record's "total_affiliated" value
 * @method decimal getSaleOfAffiliated()     Returns the current record's "sale_of_affiliated" value
 * @method decimal getTotalConsultancy()     Returns the current record's "total_consultancy" value
 * @method decimal getConsultancy()          Returns the current record's "consultancy" value
 * @method decimal getTotalIntermediation()  Returns the current record's "total_intermediation" value
 * @method decimal getIntermediation()       Returns the current record's "intermediation" value
 * @method decimal getTotalFormation()       Returns the current record's "total_formation" value
 * @method decimal getFormation()            Returns the current record's "formation" value
 * @method decimal getTotalPatents()         Returns the current record's "total_patents" value
 * @method decimal getPatents()              Returns the current record's "patents" value
 * @method Billing setId()                   Sets the current record's "id" value
 * @method Billing setYear()                 Sets the current record's "year" value
 * @method Billing setMonth()                Sets the current record's "month" value
 * @method Billing setTotalAffiliated()      Sets the current record's "total_affiliated" value
 * @method Billing setSaleOfAffiliated()     Sets the current record's "sale_of_affiliated" value
 * @method Billing setTotalConsultancy()     Sets the current record's "total_consultancy" value
 * @method Billing setConsultancy()          Sets the current record's "consultancy" value
 * @method Billing setTotalIntermediation()  Sets the current record's "total_intermediation" value
 * @method Billing setIntermediation()       Sets the current record's "intermediation" value
 * @method Billing setTotalFormation()       Sets the current record's "total_formation" value
 * @method Billing setFormation()            Sets the current record's "formation" value
 * @method Billing setTotalPatents()         Sets the current record's "total_patents" value
 * @method Billing setPatents()              Sets the current record's "patents" value
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBilling extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('billing');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('year', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 8,
             ));
        $this->hasColumn('month', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 8,
             ));
        $this->hasColumn('total_affiliated', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));
        $this->hasColumn('sale_of_affiliated', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));
        $this->hasColumn('total_consultancy', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));
        $this->hasColumn('consultancy', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));
        $this->hasColumn('total_intermediation', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));
        $this->hasColumn('intermediation', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));
        $this->hasColumn('total_formation', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));
        $this->hasColumn('formation', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));
        $this->hasColumn('total_patents', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));
        $this->hasColumn('patents', 'decimal', 9, array(
             'type' => 'decimal',
             'length' => 9,
             'scale' => '2',
             ));

        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}