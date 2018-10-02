<?php

namespace Tests\Classes;

use Ipag\Classes\Util\DateUtil;
use PHPUnit\Framework\TestCase;

class DateUtilTest extends TestCase
{
    private $dateUtil;

    public function setUp()
    {
        parent::setUp();

        $this->dateUtil = new DateUtil();

    }

    public function testIsValidDate()
    {
        $response = $this->dateUtil->isValid('10/10/1994');

        $this->assertTrue($response);
    }

    public function testIsValidDateFalse()
    {
        $response = $this->dateUtil->isValid('1994/10/39');

        $this->assertFalse($response);

        $response = $this->dateUtil->isValid('40/40/1900');

        $this->assertFalse($response);
    }
}
