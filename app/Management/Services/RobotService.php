<?php

namespace App\Management\Services;

use App\Management\Contracts\Service\Contract;

class RobotService implements Contract
{
  /**
   * Start the robot movement process
   * 
   * @return mixed
   */
  public function start($fileName) 
  {
    $parser = new FileParserService($fileName);

    $fileData = $parser->getAllCommands();

    if (is_array($fileData) && count($fileData)) {
      $commandsValidator = new CommandsValidatorService($fileData);

      $validCommands = $commandsValidator->getAllValidCommands();

      if (count($validCommands)) {
        $movement = new MovementService($validCommands);

        $output = $movement->start();

        $response = implode(newLine(), $output);
      } else {
        $response = "No Valid Commands Found in given File.";
      }
    } else {
      $response = is_string($fileData) ? $fileData : "No Commands Found in File.";
    }
    
    return $response;
  }
}