<?php

use App\Management\Services\MovementService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MovementServiceTest extends TestCase
{
   /**
     * Test Movement Commands Process: When Commands array provided
     *
     * @return void
   */
   public function testwhenCommandsArrayProvided()
   {
      $allCommands = ['PLACE 0,2,EAST', 'PLACE 2,1,SOUTH', 'RIGHT', 'REPORT'];

      $movement = new MovementService($allCommands);

      $output = $movement->start();

      $this->assertEquals(['2,1,WEST'], $output);
   }

   /**
     * Test Movement Commands Process: When Commands array empty
     *
     * @return void
   */
   public function testwhenCommandsArrayEmpty()
   {
      $allCommands = [];

      $movement = new MovementService($allCommands);

      $output = $movement->start();

      $this->assertEquals(['No Commands given for Robot Movement'], $output);
   }

   /**
     * Test Movement Commands Process: Turn Left after Place Command
     *
     * @return void
   */
   public function testTurnLeftAfterPlaceToWest()
   {
      $allCommands = ['PLACE 0,3,WEST', 'LEFT', 'REPORT'];

      $movement = new MovementService($allCommands);

      $output = $movement->start();

      $this->assertEquals(['0,3,SOUTH'], $output);
   }

   /**
     * Test Movement Commands Process: Turn right after Place Command
     *
     * @return void
   */
   public function testTurnRightAfterPlaceToWest()
   {
      $allCommands = ['PLACE 0,2,NORTH', 'RIGHT', 'REPORT'];

      $movement = new MovementService($allCommands);

      $output = $movement->start();

      $this->assertEquals(['0,2,EAST'], $output);
   }

   /**
     * Test Movement Commands Process: Move When in West direction
     *
     * @return void
   */
   public function testMoveWhileInWestDirection()
   {
      $allCommands = ['PLACE 1,2,NORTH', 'LEFT', 'MOVE', 'REPORT'];

      $movement = new MovementService($allCommands);

      $output = $movement->start();

      $this->assertEquals(['0,2,WEST'], $output);
   }

   /**
     * Test Movement Commands Process: Move When in South direction
     *
     * @return void
   */
   public function testMoveWhileInSouthDirection()
   {
      $allCommands = ['PLACE 1,2,NORTH', 'LEFT', 'LEFT', 'MOVE', 'REPORT'];

      $movement = new MovementService($allCommands);

      $output = $movement->start();

      $this->assertEquals(['1,1,SOUTH'], $output);
   }
}