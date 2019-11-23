<?php

namespace App\Management\Services;

use App\Management\Validations\RequestValidation;
use App\Management\Contracts\Service\Contract;

class RobotService implements Contract
{
  private $validator;

  public function __construct()
  {
    $this->validator = new RequestValidation;
  }

  /**
   * Start the robot movement process
   * 
   * @return mixed
   */
  public function start($request) 
  {
    $response = $this->validator->validate($request);

    if ($response === true) { 
      $parser = new FileParserService($request['file_name']);

      $commands = $parser->getAllCommands();

      if (count($commands)) {
        $commandsValidator = new CommandsValidatorService($commands);

        $validCommands = $commandsValidator->getAllValidCommands();

        if (count($validCommands)) {
          $movement = new MovementService($validCommands);

          $output = $movement->start();

          $response = implode("<br/>", $output);
        } else {
          $response = "No Valid Commands Found in given File.";
        }
      } else {
        $response = "No Commands Found in File.";
      }
    }

    return $response;
  }
}