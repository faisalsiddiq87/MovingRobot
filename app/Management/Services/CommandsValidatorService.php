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
         if ($this->isValidPlaceCommand($cmd)) {
            $getFirstValidPlaceCommandKey = $key;
            break;
         }
      }
     
      //Remove ALL Commands before the first PLACE command
      if ($getFirstValidPlaceCommandKey > -1) {
         $indexedCommands = reIndexArray($this->commands, $getFirstValidPlaceCommandKey);
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
         if ($this->isValidPlaceCommand($cmd) || $this->isValidMoveCommand($cmd) || $this->isValidLeftCommand($cmd) || 
         $this->isValidRightCommand($cmd) || $this->isValidReportCommand($cmd)) {
            $validCommands[] = $cmd;
         }
      }

      $this->setCommands($validCommands);
   }
   
   public function isValidPlaceCommand($cmd)
   {
      return matchPattern('/^PLACE\s+[0-9]+[,]+[0-9]+[,](NORTH|SOUTH|EAST|WEST)$/', $cmd) && $this->verifyPlaceCordinates($cmd);
   }

   private function verifyPlaceCordinates($cmd)
   {
      $hasValidPlaceCoordinates = false;

      $params = explode(",", str_replace(['PLACE', ' '], '', $cmd));

      $xAxis = $params[0];
  
      $yAxis = $params[1];

      if ($xAxis < env('MAX_X_AXIS') &&  $yAxis < env('MAX_Y_AXIS')) {
         $hasValidPlaceCoordinates = true;
      }

      return $hasValidPlaceCoordinates;
   }

   public function isValidMoveCommand($cmd)
   {
      return matchPattern('/^MOVE$/', $cmd);
   }

   public function isValidLeftCommand($cmd)
   {
      return matchPattern('/^LEFT$/', $cmd);
   }

   public function isValidRightCommand($cmd)
   {
      return matchPattern('/^RIGHT$/', $cmd);
   }

   public function isValidReportCommand($cmd)
   {
      return matchPattern('/^REPORT$/', $cmd);
   }
}