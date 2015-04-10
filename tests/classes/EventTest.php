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

class EventTest extends PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        $this->object = new Event;
    }

    protected function tearDown()
    {
        
    }

    /**
     * @covers Event::eventList
     * @dataProvider testEventListData
     */
    public function testEventList($data, $result)
    {
        $res = $this->object->EventList($data);
        $this->assertInternalType($result, $res);
    }

    public function testEventListData()
    {
        $data = array(
            array(
                array('date_start' => '2015-04-01 00:00:00', 'date_end' => '2015-05-01 00:00:00'), "array"
            ),
            array(
                array('date_start' => '2010-04-01 00:00:00', 'date_end' => '2010-05-01 00:00:00'), "array"
            )
        );
        return $data;
    }

    /**
     * @covers Event::checkEvent
     * @dataProvider testCheckEventData
     */
    public function testCheckEvent($data, $result)
    {
        $res = $this->object->CheckEvent($data);
        $this->assertInternalType($result, $res);
    }

    public function testCheckEventData()
    {
        $data = array(
            array(
                array('dateStart' => '2015-04-01 00:00:00',
                    'dateEnd' => '2015-05-01 00:00:00', 'roomId' => 1), "array"
            ),
            array(
                array('dateStart' => '2010-04-01 00:00:00',
                    'dateEnd' => '2010-05-01 00:00:00', 'roomId' => 1), "array"
            )
        );
        return $data;
    }

}
