<?php

use App\Management\Services\SquareTableService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SquareTableServiceTest extends TestCase
{
   /**
     * Test Square Table: When Valid Square Table Coordinates provided
     *
     * @return void
   */
   public function testifSquareTableWhenValidCoordinates()
   {
      $table = new SquareTableService('5', '5');

      $output = $table->isValidSquareTable();

      $this->assertTrue($output);
   }

   /**
     * Test Square Table: When In Valid Square Table Coordinates provided
     *
     * @return void
   */
   public function testifSquareTableWhenInValidCoordinates()
   {
      $table = new SquareTableService('5', '3');

      $output = $table->isValidSquareTable();

      $this->assertFalse($output);
   }

   /**
     * Test Square Table: if Valid Place on Square Table when Valid coordinates provided
     *
     * @return void
   */
   public function testifValidPlaceONSquareTableWithValidPoints()
   {
      $table = new SquareTableService('5', '5');

      $output = $table->isValidLocationOnTable('2', '3');

      $this->assertTrue($output);
   }

   /**
     * Test Square Table: if Valid Place on Square Table when In Valid coordinates provided
     *
     * @return void
   */
   public function testifValidPlaceONSquareTableWithInvalidPoints()
   {
      $table = new SquareTableService('5', '5');

      $output = $table->isValidLocationOnTable('5', '6');

      $this->assertFalse($output);
   }
}