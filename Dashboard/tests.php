<?php
use PHPUnit\Framework\TestCase;
require 'sql.php';

class SQLTest extends TestCase
{
    public function addLotDP() {
       return array(
           array(999,'Apple',100,"Success"),
           array(999,'Apple',90,"Duplicate entry '999' for key 'PRIMARY'"),
           array(900, 'Fake Name', 100, "Cannot add or update a child row: a foreign key constraint fails (`HandSMetals`.`Lots`, CONSTRAINT `customer_name` FOREIGN KEY (`customer`) REFERENCES `Customers` (`company`) ON DELETE CASCADE ON UPDATE CASCADE)")
       );
    }
    /**
    * @dataProvider addLotDP
    */
    public function testAddLot($lotnum, $cust, $amt, $expected) {
        $this->assertSame(addLot($lotnum, $cust, $amt), $expected);
    }
    // get_lots returns a mysqli_result object if it is successful, false otherwise
    public function testGetLots() {
        $this->assertTrue(gettype(get_lots()) == 'object');
    }
    /**
    * @depends testGetLots
    */
    public function testGetLotFields() {
        $this->assertTrue(gettype(get_fields(get_lots())) == 'array');
    }
    /**
    * @depends testGetLots
    */
    public function testGetLotRows() {
        $this->assertTrue(gettype(get_rows(get_lots())) == 'array');
    }
    /**
    * @depends testAddLot
    */
    public function testRemoveLot() {
        $this->assertTrue(removeLot(999));
    }
    public function addCustDP() {
        return array(
            array("Campus Police", "Chief", 7656774911, "campuspolice@indwes.edu", "Success"),
            array("Campus Police", "New Chief", 1234567890, "", "Duplicate entry 'Campus Police' for key 'PRIMARY'")
        );
    }
    /**
    * @dataProvider addCustDP
    */
    public function testAddCustomer($company, $contact, $phone, $email, $expected) {
        $this->assertSame(addCustomer($company, $contact, $phone, $email), $expected);
    }
    public function testGetCustomers() {
        $this->assertTrue(gettype(get_customers()) == 'object');
    }
    /**
    * @depends testGetCustomers
    */
    public function testGetCustFields() {
        $this->assertTrue(gettype(get_fields(get_customers())) == 'array');
    }
    /**
    * @depends testGetCustomers
    */
    public function testGetCustRows() {
        $this->assertTrue(gettype(get_rows(get_customers())) == 'array');
    }
    public function testGetCustomersList() {
        $this->assertTrue(gettype(get_customers_list()) == 'array');
    }
    /**
    * @depends testAddCustomer
    */
    public function testRemoveCustomer() {
        $this->assertTrue(removeCust("Campus Police"));
    }
}
