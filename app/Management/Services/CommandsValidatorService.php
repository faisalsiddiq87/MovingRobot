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

    /**
     * Validate all commands and remove bad ones
     * 
     * @return array
     */
    public function getAllValidCommands() 
    {
      
    }

}