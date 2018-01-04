<?php

namespace Tests\Classes;

use Ipag\Classes\Address;
use Ipag\Classes\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCreateAndSetCustomer()
    {
        $customer = new Customer();

        $customer
            ->setName('Fulano da Silva')
            ->setTaxpayerId('799.993.388-01')
            ->setPhone('11', '98888-3333')
            ->setEmail('fulanodasilva@gmail.com')
            ->setAddress(new Address());

        $this->assertEquals($customer->getName(), 'Fulano da Silva');
        $this->assertEquals($customer->getTaxpayerId(), '79999338801');
        $this->assertEquals($customer->getType(), 'f');
        $this->assertEquals($customer->getPhone(), '11988883333');
        $this->assertEquals($customer->getEmail(), 'fulanodasilva@gmail.com');
        $this->assertInstanceOf(Address::class, $customer->getAddress());
    }

    public function testCreateAndSetBusinessCustomer()
    {
        $customer = new Customer();

        $customer->setTaxpayerId('34.264.183/0001-74');

        $this->assertEquals($customer->getTaxpayerId(), '34264183000174');
        $this->assertEquals($customer->getType(), 'j');
    }

    public function testNewCustomerHasEmptyPhone()
    {
        $customer = new Customer();

        $this->assertEquals($customer->getPhone(), null);
    }

    public function testGetCustomerAddressIfItNotSetted()
    {
        $customer = new Customer();

        $this->assertInstanceOf(Address::class, $customer->getAddress());
    }
}
