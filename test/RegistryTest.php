<?php

namespace RobLoach\LibretroNetplayRegistry\Test;

use PHPUnit\Framework\TestCase;

class RegistryTest extends TestBase
{
    public function testInsert($username = null)
    {
        $entry = $this->randomEntry($username);
        $result = $this->registry->insert($entry, false);
        $this->assertTrue($result);
    }

    public function testSelectAll()
    {
        $username = $this->randomString(20);
        $entry = $this->randomEntry($username);
        $this->registry->insert($entry, false);
        $result = $this->registry->selectAll();
        print_r($result);
        $this->assertEquals($username, $result[0]['username']);
        $this->assertEquals(0, $result[0]['connectable']);
        $this->assertEquals(true, $result[0]['haspassword']);
    }

    public function testInsertDuplicate()
    {
        $entry = $this->randomEntry();
        $this->registry->insert($entry, false);
        $result = $this->registry->selectAll();
        $this->assertEquals(1, sizeof($result));

        $this->registry->insert($entry, false);
        $result = $this->registry->selectAll();
        $this->assertEquals(1, sizeof($result));

        $entry['coreversion'] = '1.2';
        $this->registry->insert($entry, false);
        $result = $this->registry->selectAll();
        $this->assertEquals(1, sizeof($result));
        $this->assertEquals('1.2', $result[0]['coreversion']);
    }
}
