// <?php

// namespace Jace;

// class DbTest extends \PHPUnit_Framework_TestCase
// {
//     /**
//      * @var \Jace\Db\Mysql
//      */
//     protected $_db = null;

//     public function setUp()
//     {
//         $this->_db = Db::factory('mysql', [
//                 'username' => 'username',
//                 'password' => 'password',
//                 'dbname' => 'test',
//                 'driver_options' => [],
//         ]);
//     }

//     public function testShouldBeDriverMysql()
//     {
//         $this->assertInstanceOf('\\Jace\\Db\\Driver\\Mysql', $this->_db);
//     }

//     public function testShouldBeEmptyAfterQuery()
//     {
//         $result = $this->_db->query('SELECT * FROM users WHERE name = :name', [
//             'name' => 'jaceju',
//         ]);
//         $this->assertEmpty($result);
//     }

//     /**
//      * @depends testShouldBeEmptyAfterQuery
//      */
//     public function testRowCountShouldBeOneAfterInsertion()
//     {
// //        $this->_db->insert('users', [
// //            'name' => 'jaceju',
// //            'birthDay' => '1979-05-01',
// //        ]);
// //        $profiler = $this->_db->getProfiler();
// //        $this->assertEquals(
// //            "INSERT INTO (`name`, `birthDay`) VALUES (?, ?)",
// //            $profiler->getQuery());
//     }
// }
