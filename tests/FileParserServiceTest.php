<?php

use App\Management\Services\FileParserService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class FileParserServiceTest extends TestCase
{
   /**
     * Test File Parser Process: By valid sample commands
     *
     * @return void
   */
   public function testwhenValidCommands()
   {
      $parser = new FileParserService('sample');

      $commands = $parser->getAllCommands();

      $this->assertEquals(['PLACE 0,2,EAST','PLACE 2,1,SOUTH','RIGHT','REPORT'], $commands);
   }

   /**
     * Test File Parser Process: By valid sample commands
     *
     * @return void
   */
   public function testwhenValidCommandsSecondSet()
   {
     $parser = new FileParserService('sample01');

     $commands = $parser->getAllCommands();

     $this->assertEquals(['PLACE 0,2,EAST', 'PLACE 2,1,SOUTH', 'RIGHT', 'MOVE', 'REPORT', 'MOVE',
     'LEFT', 'RIGHT', 'MOVE', 'MOVE', 'MOVE', 'MOVE', 'MOVE','MOVE', 'REPORT'], $commands);
   }

   /**
     * Test File Parser Process: By empty input file
     *
     * @return void
   */
   public function testwhenEmptyFile()
   {
      $parser = new FileParserService('sample02');

      $commands = $parser->getAllCommands();
      
      $this->assertEquals([], $commands);
   }

   /**
    * Test File Parser Process: Return all commands from input file valid/invalid
    *
    * @return void
   */
   public function testReturnAllCommands()
   {
      $parser = new FileParserService('sample03');

      $commands = $parser->getAllCommands();
      
      $this->assertEquals(['PLACE 0,2,EASTS', 'PLACE 2,1,SOUTHS', 'MOVE', 'LEFT', 'RIGHT', 'REPORT'], $commands);
   }

   /**
    * Test File Parser Process: By input file that does not exists
    *
    * @return void
   */
   public function testwithFileNotFound()
   {
      $parser = new FileParserService('sample03ss');

      $commands = $parser->getAllCommands();
      
      $this->assertEquals("File does not exist.", $commands);
   }
}