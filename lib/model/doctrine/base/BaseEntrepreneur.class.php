<?php

/**
 * BaseEntrepreneur
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property datetime $date
 * @property string $name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $linkedin
 * @property string $web_personal
 * @property string $sex
 * @property string $workstation
 * @property text $project
 * @property boolean $capital
 * @property text $comments_capital
 * @property boolean $courses
 * @property text $comments_courses
 * @property text $comments
 * @property Doctrine_Collection $Entrepreneur
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method datetime            getDate()             Returns the current record's "date" value
 * @method string              getName()             Returns the current record's "name" value
 * @method string              getLastName()         Returns the current record's "last_name" value
 * @method string              getPhone()            Returns the current record's "phone" value
 * @method string              getEmail()            Returns the current record's "email" value
 * @method string              getLinkedin()         Returns the current record's "linkedin" value
 * @method string              getWebPersonal()      Returns the current record's "web_personal" value
 * @method string              getSex()              Returns the current record's "sex" value
 * @method string              getWorkstation()      Returns the current record's "workstation" value
 * @method text                getProject()          Returns the current record's "project" value
 * @method boolean             getCapital()          Returns the current record's "capital" value
 * @method text                getCommentsCapital()  Returns the current record's "comments_capital" value
 * @method boolean             getCourses()          Returns the current record's "courses" value
 * @method text                getCommentsCourses()  Returns the current record's "comments_courses" value
 * @method text                getComments()         Returns the current record's "comments" value
 * @method Doctrine_Collection getEntrepreneur()     Returns the current record's "Entrepreneur" collection
 * @method Entrepreneur        setId()               Sets the current record's "id" value
 * @method Entrepreneur        setDate()             Sets the current record's "date" value
 * @method Entrepreneur        setName()             Sets the current record's "name" value
 * @method Entrepreneur        setLastName()         Sets the current record's "last_name" value
 * @method Entrepreneur        setPhone()            Sets the current record's "phone" value
 * @method Entrepreneur        setEmail()            Sets the current record's "email" value
 * @method Entrepreneur        setLinkedin()         Sets the current record's "linkedin" value
 * @method Entrepreneur        setWebPersonal()      Sets the current record's "web_personal" value
 * @method Entrepreneur        setSex()              Sets the current record's "sex" value
 * @method Entrepreneur        setWorkstation()      Sets the current record's "workstation" value
 * @method Entrepreneur        setProject()          Sets the current record's "project" value
 * @method Entrepreneur        setCapital()          Sets the current record's "capital" value
 * @method Entrepreneur        setCommentsCapital()  Sets the current record's "comments_capital" value
 * @method Entrepreneur        setCourses()          Sets the current record's "courses" value
 * @method Entrepreneur        setCommentsCourses()  Sets the current record's "comments_courses" value
 * @method Entrepreneur        setComments()         Sets the current record's "comments" value
 * @method Entrepreneur        setEntrepreneur()     Sets the current record's "Entrepreneur" collection
 * 
 * @package    egauss
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEntrepreneur extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('entrepreneur');
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
        $this->hasColumn('name', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
        $this->hasColumn('last_name', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('phone', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('email', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('linkedin', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('web_personal', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('sex', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('workstation', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('project', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('capital', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('comments_capital', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('courses', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('comments_courses', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('comments', 'text', null, array(
             'type' => 'text',
             ));

        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('VideosRegisteredCompanies as Entrepreneur', array(
             'local' => 'id',
             'foreign' => 'entrepreneur_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}