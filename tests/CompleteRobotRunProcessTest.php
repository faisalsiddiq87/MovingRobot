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
      $this->get('run/sample');
      
      $this->assertEquals("2,1,WEST", $this->response->getContent());
   }

   /**
     * Test Complete Robot Movement Process: By valid sample 01 commands
     *
     * @return void
   */
   public function testwithValidCommandsSampleTwo()
   {
      $this->get('run/sample01');
      
      $this->assertEquals("1,1,WEST\n0,1,WEST", $this->response->getContent());
   }

   /**
     * Test Complete Robot Movement Process: By empty input file
     *
     * @return void
   */
   public function testwithEmptyFile()
   {
      $this->get('run/sample02');
      
      $this->assertEquals("No Commands Found in File.", $this->response->getContent());
   }

   /**
     * Test Complete Robot Movement Process: By all invalid commands from input file
     *
     * @return void
   */
   public function testwithAllInvalidCommands()
   {
      $this->get('run/sample03');
      
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