<?php

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    public function testCreateAndSetAuthentication()
    {
        $auth = new \Ipag\Classes\Authentication('app@test.com', '123456');
        $auth->setPartner('sub.app@test.com');

        $this->assertEquals($auth->getIdentification(), 'app@test.com');
        $this->assertEquals($auth->getApiKey(), '123456');
        $this->assertEquals($auth->getPartner(), 'sub.app@test.com');

        $auth->setIdentification('other@test.com')
            ->setApiKey('654321');

        $this->assertEquals($auth->getIdentification(), 'other@test.com');
        $this->assertEquals($auth->getApiKey(), '654321');
    }
}
