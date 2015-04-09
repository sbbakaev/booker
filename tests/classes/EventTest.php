<?php

require_once '../config.php';

function __autoload($classname)
{
    $filename = "../classes/" . $classname . ".php";
    if (file_exists($filename))
    {
        include_once($filename);
    } else
    {
        echo 'File not found ' . $filename;
    }
}

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-04-09 at 01:29:37.
 */
class EventTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Event
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Event;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Event::eventList
     * @dataProvider testEventListData
     */
    public function testEventList($data,$result)
    {

      //  $this->assertEquals('foo', $data);
         $res = $this->object->EventList($data);
         $this->assertInternalType($result,$res);
    }

    public function testEventListData()
    {
        $data = array(
            array (
                    array('date_start' => '2015-04-01 00:00:00', 'date_end' => '2015-05-01 00:00:00'),"array"
                ) ,
           array ( 
               array ('date_start' => '2010-04-01 00:00:00', 'date_end' => '2010-05-01 00:00:00' ),"array"
               ) 
        );
        return $data;
    }

    /**
     * @covers Event::checkEvent
     * @dataProvider testCheckEventData
     */
    public function testCheckEvent($data,$result)
    {
          $res = $this->object->CheckEvent($data);
         $this->assertInternalType($result,$res);
    }

    public function testCheckEventData()
    {
        $data = array(
            array (
                    array('dateStart' => '2015-04-01 00:00:00', 
                        'dateEnd' => '2015-05-01 00:00:00','roomId'=>1),"array"
                ) ,
           array ( 
               array ('dateStart' => '2010-04-01 00:00:00', 
                   'dateEnd' => '2010-05-01 00:00:00','roomId'=>1 ),"array"
               ) 
        );
        return $data;
    }

    /**
     * @covers Event::updateEvent
     * @todo   Implement testUpdateEvent().
     */
    public function testUpdateEvent()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Event::updateRecurrentEvent
     * @todo   Implement testUpdateRecurrentEvent().
     */
    public function testUpdateRecurrentEvent()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Event::createEvent
     * @todo   Implement testCreateEvent().
     */
    public function testCreateEvent()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Event::deleteEvent
     * @todo   Implement testDeleteEvent().
     */
    public function testDeleteEvent()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Event::getRooms
     * @todo   Implement testGetRooms().
     */
    public function testGetRooms()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
