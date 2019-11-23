<?php

namespace App\Management\Services;

use App\Management\Validations\RequestValidation;
use App\Management\Contracts\Service\Contract;

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

  private function setNewLocationAxis($x, $y)
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
            $availableLocation = $this->report();
            if ($availableLocation) {
              echo $availableLocation . '<br/>';
            }
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

    if ($this->isAllowedToMove($newX, $newY)) {
      $this->setNewLocationAxis($newX, $newY);
      $this->setDirection($newDirection);
    }
  }

  private function move() 
  {
    $currentLocation = $this->getCurrentLocation();

    $currentXAxis = $currentLocation['x'];

    $currentYAxis = $currentLocation['y'];

    $currentDirection = $currentLocation['direction'];

    if ($currentDirection == 'EAST') {
      $currentXAxis += 1;
    } else if ($currentDirection == 'WEST') {
      $currentXAxis -= 1;
    } else if ($currentDirection == 'NORTH') {
      $currentYAxis += 1;
    } else {
      $currentYAxis -= 1;
    }

    if ($this->isAllowedToMove($currentXAxis, $currentYAxis)) {
      $this->setNewLocationAxis($currentXAxis, $currentYAxis);
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

    return $currentLocation['direction'] ? $currentLocation['x'] . ',' . $currentLocation['y'] . ',' . $currentLocation['direction'] : '';
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