<?php

namespace App\Management\Services;

use App\Management\Validations\RequestValidation;
use App\Management\Contracts\Service\Contract;

class FileParserService implements Contract
{
    private $fileName;

    public function __construct($fileName = '')
    {
      $this->fileName = $fileName;
    }

    private function getFileName()
    {
      return $this->fileName;
    }

    /**
     * Return all commands given in file
     * 
     * @return array
     */
    public function getAllCommands() 
    {
      $file = base_path('public') . DIRECTORY_SEPARATOR . env('FILES_DIRECTORY') . DIRECTORY_SEPARATOR . $this->getFileName() . '.txt';

      if (file_exists($file)) {
        $data = rtrim(@file_get_contents($file));
        $response = $data ? array_map('trim', (explode("\n", $data))) : [];
      } else {
        $response = "File does not exist.";
      }

      return $response;
    }
}