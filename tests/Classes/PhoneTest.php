<?php

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testCreateAndSetPhone()
    {
        $phone = new \Ipag\Classes\Phone;

        $phone->setAreaCode('11')->setNumber('95555-5555');

        $this->assertEquals('11', $phone->getAreaCode());
        $this->assertEquals('955555555', $phone->getNumber());
    }
}
