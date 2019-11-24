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

  private function getDirections()
  {
    return [self::EAST, self::NORTH, self::WEST, self::SOUTH];
  }

  /**
   * Start Robot Movement
   * 
   * @array
   */
  public function start() 
  {
    $output = [];

    if ($this->isSquareTable()) {
      $allCommands = $this->getCommands();
      if (count($allCommands)) {
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
                $output[] = $availableLocation;
              }
            break;
            default:
              $this->place($cmd);
            break;
          }
        }
      } else {
        $output[] = "No Commands given for Robot Movement";
      }
    } else {
      $output[] = "No Square Table Found for Robot Movement";
    }

    return $output;
  }

  private function place($cmd) 
  {
    $parsedCommand  = $this->parsePlaceCommand($cmd);

    if ($this->isAllowedToMove($parsedCommand['x'], $parsedCommand['y'])) {
      $this->setNewLocationAxis($parsedCommand['x'], $parsedCommand['y']);
      $this->setDirection($parsedCommand['direction']);
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

    $directions = $this->getDirections();

    $currentDirectionKey = array_search($currentDirection, $directions);

    if ($currentDirectionKey == 3) {
      $newDirection = $directions[0];
    } else {
      $newDirection = $directions[$currentDirectionKey+1];
    }

    $this->setDirection($newDirection);
  }

  private function right()
  {
    $currentLocation = $this->getCurrentLocation();

    $currentDirection = $currentLocation['direction'];

    $directions = $this->getDirections();

    $currentDirectionKey = array_search($currentDirection, $directions);

    if ($currentDirectionKey == 0) {
      $newDirection = $directions[3];
    } else {
      $newDirection = $directions[$currentDirectionKey-1];
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

  private function parsePlaceCommand($cmd)
  {
    $params = explode(",", str_replace(['PLACE', ' '], '', $cmd));

    return ['x' => $params[0], 'y' => $params[1], 'direction' => $params[2]];
  }
}