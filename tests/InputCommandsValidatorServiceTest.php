<?php

use App\Management\Services\CommandsValidatorService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CommandsValidatorServiceTest extends TestCase
{
   /**
     * Test Commands Validation Process: By valid sample commands array
     *
     * @return void
   */
   public function testwhenAllValidCommandsArrayProvided()
   {
      $allCommands = ['PLACE 0,2,EAST', 'PLACE 2,1,SOUTH', 'RIGHT', 'REPORT'];

      $parser = new CommandsValidatorService($allCommands);

      $commands = $parser->getAllValidCommands();

      $this->assertEquals($allCommands, $commands);
   }

   /**
     * Test Commands Validation Process: By valid sample commands array
     *
     * @return void
   */
   public function testwhenAllValidCommandsArraySecondSetProvided()
   {
      $allCommands = ['PLACE 0,2,EAST', 'PLACE 2,1,SOUTH', 'RIGHT', 'MOVE', 'REPORT', 'MOVE',
      'LEFT', 'RIGHT', 'MOVE', 'MOVE', 'MOVE', 'MOVE', 'MOVE','MOVE', 'REPORT'];

      $parser = new CommandsValidatorService($allCommands);

      $commands = $parser->getAllValidCommands();

      $this->assertEquals($allCommands, $commands);
   }

   /**
     * Test Commands Validation Process: By few invalid sequence commands before place commands
     *
     * @return void
   */
   public function testwhenInvalidSequenceOFCommandsArrayProvided()
   {
      $allCommands = ['RIGHT', 'MOVE', 'REPORT', 'PLACE 0,1,EAST', 'RIGHT', 'MOVE', 'REPORT', 'MOVE',
      'LEFT', 'MOVE','MOVE', 'REPORT'];

      $parser = new CommandsValidatorService($allCommands);

      $commands = $parser->getAllValidCommands();

      $this->assertEquals(['PLACE 0,1,EAST', 'RIGHT', 'MOVE', 'REPORT', 'MOVE',
      'LEFT', 'MOVE','MOVE', 'REPORT'], $commands);
   }

   /**
     * Test Commands Validation Process: When no commands provided
     *
     * @return void
   */
   public function testwhenEmptyCommandsArrayProvided()
   {
      $allCommands = [];

      $parser = new CommandsValidatorService($allCommands);

      $commands = $parser->getAllValidCommands();

      $this->assertEquals([], $commands);
   }

   /**
     * Test Commands Validation Process: When all invalid commands provided
     *
     * @return void
   */
   public function testwhenOnlyInvalidCommandsArrayProvided()
   {
      $allCommands = ['dssada', 'sdsadasdas', 'placed 0, 9, north', 'dsadsadasdas', 'moved', 'left', 'report'];

      $parser = new CommandsValidatorService($allCommands);

      $commands = $parser->getAllValidCommands();

      $this->assertEquals([], $commands);
   }

   /**
     * Test Commands Validation Process: When both valid and invalid commands provided
     *
     * @return void
   */
   public function testwhenBothValidInvalidCommandsProvided()
   {
      $allCommands = ['d22ssada', 'sds33adasdas', 'placed 0, 1, east', 'PLACE 0,4,EAST', 'RIGHT', 'MOVE', 'REPORT', 'movessd', 'left', 'report'];

      $parser = new CommandsValidatorService($allCommands);

      $commands = $parser->getAllValidCommands();

      $this->assertEquals(['PLACE 0,4,EAST', 'RIGHT', 'MOVE', 'REPORT'], $commands);
   }

   /**
     * Test Commands Validation Process: When valid place command provided
     *
     * @return void
   */
   public function testIfIsValidPlaceCommand()
   {
      $command = 'PLACE 0,4,EAST';

      $parser = new CommandsValidatorService([]);

      $isValidcommand = $parser->isValidPlaceCommand($command);

      $this->assertTrue($isValidcommand);
   }

   /**
     * Test Commands Validation Process: When invalid place command provided
     *
     * @return void
   */
   public function testIfIsInValidPlaceCommand()
   {
      $command = 'PLACE 6,15,EAST';

      $parser = new CommandsValidatorService([]);

      $isValidcommand = $parser->isValidPlaceCommand($command);

      $this->assertFalse($isValidcommand);
   }

   /**
     * Test Commands Validation Process: When valid move command provided
     *
     * @return void
   */
   public function testIfValidMoveCommand()
   {
      $command = 'MOVE';

      $parser = new CommandsValidatorService([]);

      $isValidcommand = $parser->isValidMoveCommand($command);

      $this->assertEquals(1, $isValidcommand);
   }

   /**
     * Test Commands Validation Process: When valid left command provided
     *
     * @return void
   */
   public function testIfValidLeftCommand()
   {
      $command = 'LEFT';

      $parser = new CommandsValidatorService([]);

      $isValidcommand = $parser->isValidLeftCommand($command);

      $this->assertEquals(1, $isValidcommand);
   }

   /**
     * Test Commands Validation Process: When valid right command provided
     *
     * @return void
   */
   public function testIfValidRightCommand()
   {
      $command = 'RIGHT';

      $parser = new CommandsValidatorService([]);

      $isValidcommand = $parser->isValidRightCommand($command);

      $this->assertEquals(1, $isValidcommand);
   }

   /**
     * Test Commands Validation Process: When valid report command provided
     *
     * @return void
   */
  public function testIfValidReportCommand()
  {
     $command = 'REPORT';

     $parser = new CommandsValidatorService([]);

     $isValidcommand = $parser->isValidReportCommand($command);

     $this->assertEquals(1, $isValidcommand);
  }
}