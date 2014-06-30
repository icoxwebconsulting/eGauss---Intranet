<?php

/**
 * BaseProductRegisteredCompanies
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $product_id
 * @property integer $registered_companies_id
 * @property Product $Product
 * @property RegisteredCompanies $RegisteredCompanies
 * 
 * @method integer                    getId()                      Returns the current record's "id" value
 * @method integer                    getProductId()               Returns the current record's "product_id" value
 * @method integer                    getRegisteredCompaniesId()   Returns the current record's "registered_companies_id" value
 * @method Product                    getProduct()                 Returns the current record's "Product" value
 * @method RegisteredCompanies        getRegisteredCompanies()     Returns the current record's "RegisteredCompanies" value
 * @method ProductRegisteredCompanies setId()                      Sets the current record's "id" value
 * @method ProductRegisteredCompanies setProductId()               Sets the current record's "product_id" value
 * @method ProductRegisteredCompanies setRegisteredCompaniesId()   Sets the current record's "registered_companies_id" value
 * @method ProductRegisteredCompanies setProduct()                 Sets the current record's "Product" value
 * @method ProductRegisteredCompanies setRegisteredCompanies()     Sets the current record's "RegisteredCompanies" value
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProductRegisteredCompanies extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('product_registered_companies');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('product_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('registered_companies_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));

        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Product', array(
             'local' => 'product_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasOne('RegisteredCompanies', array(
             'local' => 'registered_companies_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}