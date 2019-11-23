<?php

namespace App\Management\Services;

use App\Management\Validations\RequestValidation;
use App\Management\Contracts\Service\Contract;

class CommandsValidatorService implements Contract
{
   private $commands;

   public function __construct($commands = [])
   {
      $this->commands = $commands;
   }

   private function getCommands()
   {
      return $this->commands;
   }

   private function setCommands($commands)
   {
      $this->commands = $commands;
   }

   /**
    * Validate all commands and remove bad ones
    * 
    * @return array
    */
   public function getAllValidCommands() 
   {
      $this->ignoreAllPreCommandsTillPlaceCommand();

      $this->removeAllBadCommands();

      return $this->getCommands();
   }

   /**
    * First Valid Command should be PLACE Command
    * 
    * Ignore/Remove All commands before first valid PLACE Command
    * 
    * @void
    */
   private function ignoreAllPreCommandsTillPlaceCommand()
   {
      $getFirstValidPlaceCommandKey = -1;
   
      foreach ($this->commands as $key => $cmd) {
         $cmd = trim($cmd);
         if ($this->isValidPlaceCommand($cmd)) {
            $getFirstValidPlaceCommandKey = $key;
            break;
         }
      }
     
      //Remove ALL Commands before the first PLACE command
      if ($getFirstValidPlaceCommandKey > -1) {
         $indexedCommands = $this->reindexArray($getFirstValidPlaceCommandKey);
         $this->setCommands($indexedCommands);
      } else {
         $this->setCommands([]);
      }
   }

   /**
    * Match All Commands(PLACE/MOVE/RIGHT/LEFT/REPORT) against REGEX
    * 
    * Remove all invalid commands
    * 
    * @void
    */
   private function removeAllBadCommands()
   {
      $validCommands = [];

      foreach ($this->commands as $cmd) {
         $cmd = trim($cmd);
         if ($this->isValidPlaceCommand($cmd) || $this->isValidMoveCommand($cmd) || $this->isValidLeftCommand($cmd) || 
         $this->isValidRightCommand($cmd) || $this->isValidReportCommand($cmd)) {
            $validCommands[] = $cmd;
         }
      }

      $this->setCommands($validCommands);
   }
   
   private function isValidPlaceCommand($cmd)
   {
      return $this->matchPattern('/^PLACE\s+[0-9]+[,]+[0-9]+[,](NORTH|SOUTH|EAST|WEST)$/', $cmd) && $this->verifyPlaceCordinates($cmd);
   }

   private function verifyPlaceCordinates($cmd)
   {
      $hasValidPlaceCoordinates = false;

      $parseCommand  = str_replace(['PLACE', ' '], '', $cmd);

      $params = explode(",", $parseCommand);

      $xAxis = $params[0];
  
      $yAxis = $params[1];

      if ($xAxis < env('MAX_X_AXIS') &&  $yAxis < env('MAX_Y_AXIS')) {
         $hasValidPlaceCoordinates = true;
      }

      return $hasValidPlaceCoordinates;
   }

   private function isValidMoveCommand($cmd)
   {
      return $this->matchPattern('/^MOVE$/', $cmd);
   }

   private function isValidLeftCommand($cmd)
   {
      return $this->matchPattern('/^LEFT$/', $cmd);
   }

   private function isValidRightCommand($cmd)
   {
      return $this->matchPattern('/^RIGHT$/', $cmd);
   }

   private function isValidReportCommand($cmd)
   {
      return $this->matchPattern('/^REPORT$/', $cmd);
   }

   private function matchPattern($pattern, $cmd)
   {
      return preg_match($pattern, $cmd) ? 1 : 0;
   }

   private function reindexArray($index)
   {
      return array_values(array_slice($this->commands, $index, NULL, TRUE));
   }
}