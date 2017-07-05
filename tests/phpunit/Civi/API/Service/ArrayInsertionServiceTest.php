<?php

namespace phpunit\Civi\API\Service;

use Civi\API\Service\ArrayInsertionService;
use Civi\API\V4\UnitTestCase;

class ArrayInsertionServiceTest extends UnitTestCase {

  public function testInsertWillWork() {
    $arr = array();
    $path = ['foo' => false, 'bar' => false];
    $inserter = new ArrayInsertionService();
    $inserter::insert($arr, $path, array('LALA'));

    $expected = array(
      'foo' => array(
        'bar' => 'LALA'
      )
    );

    $this->assertEquals($expected, $arr);
  }

  public function testInsertionOfContactEmailLocation() {
    $contacts = array(
      array(
        'id' => 1,
        'first_name' => 'Jim'
      ),
      array(
        'id' => 2,
        'first_name' => 'Karen'
      )
    );
    $emails = array(
      array(
        'email' => 'jim@jim.com',
        'id' => 2,
        '_parent_id' => 1
      )
    );
    $locationTypes = array(
      array(
        'name' => 'Home',
        'id' => 3,
        '_parent_id' => 2
      ),
    );

    $emailPath = ['emails' => true];
    $locationPath = ['emails' => true, 'location' => false];
    $inserter = new ArrayInsertionService();

    foreach ($contacts as &$contact) {
      $inserter::insert($contact, $emailPath, $emails);
      $inserter::insert($contact, $locationPath, $locationTypes);
    }

    $locationType = $contacts[0]['emails'][0]['location']['name'];
    $this->assertEquals('Home', $locationType);
  }
}
