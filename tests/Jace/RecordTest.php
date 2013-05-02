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
    public function setUp()
    {
        $dsn = 'mysql:dbname=test;host=127.0.0.1';
        $username = 'username';
        $password = 'password';

        $user = new User($dsn, $username, $password);
        $user->truncate();
    }

    public function tearDown()
    {
    }

    public function testIdShouldBeOneAfterSave()
    {
        $dsn = 'mysql:dbname=test;host=127.0.0.1';
        $username = 'username';
        $password = 'password';

        $user = new User($dsn, $username, $password);
        $user->name = 'jaceju';
        $user->birthday = '1970-05-01';
        $user->save();
        $this->assertEquals(1, $user->id);
    }

    /**
     * @depends testIdShouldBeOneAfterSave
     */
    public function testItShouldBeSameNameAfterFind()
    {
        $dsn = 'mysql:dbname=test;host=127.0.0.1';
        $username = 'username';
        $password = 'password';

        $user = new User($dsn, $username, $password);
        $user->name = 'jaceju';
        $user->birthday = '1970-05-01';
        $user->save();

        $user = (new User($dsn, $username, $password))->find(1);
        $this->assertEquals('jaceju', $user->name);
    }

    /**
     * @depends testItShouldBeSameNameAfterFind
     */
    public function testItShouldBeOtherNameAfterSave()
    {
        $dsn = 'mysql:dbname=test;host=127.0.0.1';
        $username = 'username';
        $password = 'password';

        $user = new User($dsn, $username, $password);
        $user->name = 'jaceju';
        $user->birthday = '1970-05-01';
        $user->save();

        $user = (new User($dsn, $username, $password))->find(1);
        $this->assertEquals('jaceju', $user->name);

        $user->name = 'rickysu';
        $user->save();
        $this->assertEquals('rickysu', $user->name);
    }

}
