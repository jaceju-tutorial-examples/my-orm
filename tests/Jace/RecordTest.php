<?php

namespace Jace;

class User extends Record
{
    protected $_tableName = 'users';

    protected $_data = [
        'id'       => null,
        'name'     => null,
        'birthday' => null,
    ];
}

class RecordTest extends \PHPUnit_Framework_TestCase
{
    protected $_user = null;

    public function setUp()
    {
        $dsn = 'mysql:dbname=test;host=127.0.0.1';
        $username = 'username';
        $password = 'password';

        $this->_user = new User($dsn, $username, $password);
        $this->_user->truncate();
    }

    public function tearDown()
    {
        $this->_user = null;
    }

    public function testIdShouldBeOneAfterSave()
    {
        $this->_user->name = 'jaceju';
        $this->_user->birthday = '1970-05-01';
        $this->_user->save();
        $this->assertEquals(1, $this->_user->id);
    }

    /**
     * @depends testIdShouldBeOneAfterSave
     */
    public function testItShouldBeSameNameAfterFind()
    {
        $this->_user->name = 'jaceju';
        $this->_user->birthday = '1970-05-01';
        $this->_user->save();

        $this->_user = $this->_user->find(1);
        $this->assertEquals('jaceju', $this->_user->name);
    }

    /**
     * @depends testItShouldBeSameNameAfterFind
     */
    public function testItShouldBeOtherNameAfterSave()
    {
        $this->_user->name = 'jaceju';
        $this->_user->birthday = '1970-05-01';
        $this->_user->save();

        $this->_user = $this->_user->find(1);
        $this->assertEquals('jaceju', $this->_user->name);

        $this->_user->name = 'rickysu';
        $this->_user->save();
        $this->assertEquals('rickysu', $this->_user->name);
    }

}
