<?php

namespace App\Management\Services;

use App\Management\Validations\RequestValidation;
use App\Management\Contracts\Service\Contract;
use Illuminate\Http\Request;

class MovementService implements Contract
{
  const EAST  = 'EAST';

  const WEST = 'WEST';

  const NORTH  = 'NORTH';

  const SOUTH  = 'SOUTH';

  private $commands;

  private $table;

  private $points = ['x' => 0, 'y' => 0, 'direction' => ''];

  public function __construct($commands = [])
  {
    $this->commands = $commands;

    $this->table = new SquareTableService(env('MAX_X_AXIS'), env('MAX_Y_AXIS'));
  }

  private function setPoints($x, $y)
  {
    $this->points['x'] = $x;

    $this->points['y'] = $y;
  }

  private function setDirection($direction)
  {
    $this->points['direction'] = $direction;
  }

  private function getCurrentLocation()
  {
    return $this->points;
  }

  private function getCommands()
  {
    return $this->commands;
  }

  /**
   * Start Robot Movement
   * 
   * @void
   */
  public function start() 
  {
    if ($this->isSquareTable()) {
      $allCommands = $this->getCommands();

      foreach ($allCommands as $cmd) {
        switch ($cmd) {
          case 'MOVE':
            $this->move();
          break;
          case 'LEFT':
            $this->left();
          break;
          case 'RIGHT':
            $this->right();
          break;
          case 'REPORT':
            echo $this->report() . '<br/>';
          break;
          default:
            $this->place($cmd);
          break;
        }
      }
    } else {
      echo "No Square Table available for robot movement";
    }
  }

  private function place($cmd) 
  {
    $parseCommand  = str_replace(['PLACE', ' '], '', $cmd);

    $params = explode(",", $parseCommand);

    $newX = $params[0];

    $newY = $params[1];

    $newDirection = $params[2];

    $currentLocation = $this->getCurrentLocation();

    $x = $currentLocation['x'] + $newX;

    $y = $currentLocation['y'] + $newY;
    
    if ($this->isAllowedToMove($x, $y)) {
      $this->setPoints($x, $y);
      $this->setDirection($newDirection);
    }
  }

  private function move() 
  {
    $currentLocation = $this->getCurrentLocation();

    $x = $currentLocation['x'];

    $y = $currentLocation['y'];

    $currentDirection = $currentLocation['direction'];

    if ($currentDirection == 'EAST' || $currentDirection == 'WEST') {
      $x += 1;
    } else {
      $y += 1;
    }

    if ($this->isAllowedToMove($x, $y)) {
      $this->setPoints($x, $y);
    }
  }

  private function left()
  {
    $currentLocation = $this->getCurrentLocation();

    $currentDirection = $currentLocation['direction'];

    if ($currentDirection == self::EAST) {
      $newDirection = self::NORTH;
    } else if ($currentDirection == self::NORTH) {
      $newDirection = self::WEST;
    } else if ($currentDirection == self::WEST) {
      $newDirection = self::SOUTH;
    } else {
      $newDirection = self::EAST;
    }

    $this->setDirection($newDirection);
  }

  private function right()
  {
    $currentLocation = $this->getCurrentLocation();

    $currentDirection = $currentLocation['direction'];

    if ($currentDirection == self::EAST) {
      $newDirection = self::SOUTH;
    } else if ($currentDirection == self::SOUTH) {
      $newDirection = self::WEST;
    } else if ($currentDirection == self::WEST) {
      $newDirection = self::NORTH;
    } else {
      $newDirection = self::EAST;
    }

    $this->setDirection($newDirection);
  }

  private function report()
  {
    $currentLocation = $this->getCurrentLocation();

    return $currentLocation['x'] . ',' . $currentLocation['y'] . ',' . $currentLocation['direction'];
  }

  private function isAllowedToMove($x, $y)
  {
    return $this->table->isValidLocationOnTable($x, $y);
  }

  private function isSquareTable()
  {
    return $this->table->isValidSquareTable();
  }
}