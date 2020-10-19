<!-- * Copyright 2020 Marshall Brown, Josiah Schmidt, Micah Withers
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
* See the License for the specific language governing permissions and
* limitations under the License. -->
<?php
use PHPUnit\Framework\TestCase;
require 'sql.php';

class SQLTest extends TestCase
{
    // US get_lots returns a mysqli_result object if it is successful, boolean otherwise
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

    public function addCustDP() {
        return array(
            array("Campus Police", "Chief", 7656774911, "campuspolice@indwes.edu", "Success"),
            array("Campus Police", "New Chief", 1234567890, "", "Duplicate entry 'Campus Police' for key 'PRIMARY'")
        );
    }
    /**
    * @dataProvider addCustDP
    */
    // US 4.4, 5.1.2 tests add customer queries to database for correct feedback
    public function testAddCustomer($company, $contact, $phone, $email, $expected) {
        $this->assertSame(addCustomer($company, $contact, $phone, $email), $expected);
    }

    // US 3.1 add lot to database (dataProvider for testAddLot)
    public function addLotDP() {
       return array(
           array(999,'Campus Police',"Success"),
           array(999,'Campus Police',"Duplicate entry '999' for key 'PRIMARY'"),
           array(900, 'Fake Name',"Cannot add or update a child row: a foreign key constraint fails (`HandSMetals`.`Lots`, CONSTRAINT `customer_name` FOREIGN KEY (`customer`) REFERENCES `Customers` (`company`) ON DELETE CASCADE ON UPDATE CASCADE)")
       );
    }
    /**
    * @dataProvider addLotDP
    */
    // US 3.1, 6.3 tests add lot to database for correct feedback
    public function testAddLot($lotnum, $cust, $expected) {
        $this->assertSame(addLot($lotnum, $cust), $expected);
    }

    // US 4.3  tests retrieving customers table from database
    //      get_customers() will be an object if successful,
    //      and a boolean otherwise
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
    // US 6.2 tests whether an array is retrieved from the database
    public function testGetCustomersList() {
        $this->assertTrue(gettype(get_customers_list()) == 'array');
    }

    // US 7.6: add pallet to database (dataProvider for testAddPallet and testGetLotNet)
    public function addPalletDP() {
       return array(
           array(999,50000, 10000, "Success"),
           array(999, 20000, 30000, "Out of range value for column 'net' at row 1"),
           array(900, 40000, 20000, "Cannot add or update a child row: a foreign key constraint fails (`HandSMetals`.`Pallets`, CONSTRAINT `lotnum_fk` FOREIGN KEY (`lotnum`) REFERENCES `Lots` (`lotnum`) ON DELETE CASCADE ON UPDATE CASCADE)")
       );
    }

    /**
    * @dataProvider addPalletDP
    */
    // US 7.6: tests add pallet to database for correct feedback
    public function testAddPallet($lotnum, $gross, $tare, $expected) {
        $this->assertSame(addPallet($lotnum, $gross, $tare), $expected);
    }

    /**
    * @depends testAddPallet
    * @dataProvider addPalletDP
    */
    // US 8.4: tests getLotNet
    public function testGetLotNet($lotnum, $gross, $tare, $expected) {
        if ($expected == "Success") {
            $this->assertSame((int)getLotNet($lotnum), $gross - $tare);
        }
        else {
            $this->assertTrue(true);
        }
    }

    /**
    * @depends testAddPallet
    */
    // US 8.3: tests get_num_pallets
    public function testGetNumPallets() {
        $this->assertSame(get_num_pallets()[999], 1);
        addPallet(999, 10000, 5000);
        $this->assertSame(get_num_pallets()[999], 2);
    }

    /**
    * @depends testAddLot
    */
    // Helper function for testing
    public function testRemoveLot() {
        $this->assertTrue(removeLot(999));
    }
    /**
    * @depends testAddCustomer
    */
    // Helper function for testing
    public function testRemoveCustomer() {
        $this->assertTrue(removeCust("Campus Police"));
    }
}
