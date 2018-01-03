<?php

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testCreateAndCompleteSetAddress()
    {
        $address = new \Ipag\Classes\Address();

        $address->setStreet('Rua Manoel da Silva')
            ->setNumber('10000')
            ->setComplement('Apto 405')
            ->setNeighborhood('Centro')
            ->setCity('São Paulo')
            ->setState('SPPPP')
            ->setCountry('BRAAA')
            ->setZipCode('01156-060');

        $this->assertEquals($address->getStreet(), 'Rua Manoel da Silva');
        $this->assertEquals($address->getNumber(), '10000');
        $this->assertEquals($address->getComplement(), 'Apto 405');
        $this->assertEquals($address->getNeighborhood(), 'Centro');
        $this->assertEquals($address->getCity(), 'São Paulo');
        $this->assertEquals($address->getState(), 'SP');
        $this->assertEquals($address->getCountry(), 'BRA');
        $this->assertEquals($address->getZipCode(), '01156060');
        $this->assertEquals(strlen($address->getZipCode()), 8);
    }

}
