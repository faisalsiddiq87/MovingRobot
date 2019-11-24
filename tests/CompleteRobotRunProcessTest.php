<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CompleteProcessTest extends TestCase
{
   /**
     * Test Complete Robot Movement Process: By valid sample commands
     *
     * @return void
   */
   public function testwithValidCommands()
   {
      $this->get('run/ValidCommands');
      
      $this->assertEquals("2,1,WEST", $this->response->getContent());
   }

   /**
     * Test Complete Robot Movement Process: By valid sample 01 commands
     *
     * @return void
   */
   public function testwithValidCommandsSampleTwo()
   {
      $this->get('run/ValidCommandsOne');
      
      $this->assertEquals("1,1,WEST\n0,1,WEST", $this->response->getContent());
   }

   /**
     * Test Complete Robot Movement Process: By valid ignoring valid Commands till first valid place command
     *
     * @return void
   */
  public function testByIgnoringCommandsTillPlaceCommand()
  {
     $this->get('run/IgnoreAllCommandBeforeValidPlace');
     
     $this->assertEquals("1,3,SOUTH\n1,4,NORTH\n1,4,NORTH\n1,4,EAST\n2,4,WEST\n1,4,WEST", $this->response->getContent());
  }

   /**
     * Test Complete Robot Movement Process: By empty input file
     *
     * @return void
   */
   public function testwithEmptyFile()
   {
      $this->get('run/EmptyFile');
      
      $this->assertEquals("No Commands Found in File.", $this->response->getContent());
   }

   /**
     * Test Complete Robot Movement Process: By all invalid commands from input file
     *
     * @return void
   */
   public function testwithAllInvalidCommands()
   {
      $this->get('run/NoValidPlaceCommand');
      
      $this->assertEquals("No Valid Commands Found in given File.", $this->response->getContent());
   }

   /**
     * Test Complete Robot Movement Process: By input file that does not exists
     *
     * @return void
   */
  public function testwithFileNotFound()
  {
     $this->get('run/sample0003');
     
     $this->assertEquals("File does not exist.", $this->response->getContent());
  }
}