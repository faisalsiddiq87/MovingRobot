<?php

namespace App\Management\Services;

use App\Management\Validations\RequestValidation;
use App\Management\Contracts\Service\Contract;
use Illuminate\Http\Request;

class FileParserService implements Contract
{
    private $fileName;

    public function __construct($fileName = '')
    {
      $this->fileName = $fileName;
    }

    /**
     * Return all commands given in file
     * 
     * @return array
     */
    public function getAllCommands() 
    {
      //If File exists will send commands array as output.
      //Else Error will be shown automatically by general error handler class App\Exceptions\Handler
      return explode("\n", file_get_contents(env('FILES_DIRECTORY') . '/'. $this->fileName . '.txt'));
    }
}