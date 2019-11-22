<?php

namespace App\Management\Services;

use App\Management\Validations\RequestValidation;
use App\Management\Contracts\Service\Contract;
use Illuminate\Http\Request;

class CommandsValidatorService implements Contract
{
   private $commands;

   public function __construct($commands = [])
   {
      $this->commands = $commands;
   }

   public function getCommands()
   {
      return $this->commands;
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
         $this->commands = $this->reindexArray($getFirstValidPlaceCommandKey);
      } else {
         $this->commands = [];
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

      $this->commands = $validCommands;
   }
   
   private function isValidPlaceCommand($cmd)
   {
      return $this->matchPattern('/^PLACE\s+[0-9]+[,]+[0-9]+[,](NORTH|SOUTH|EAST|WEST)$/', $cmd);
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