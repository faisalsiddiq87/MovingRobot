<?php

namespace App\Management\Services;

use App\Management\Validations\RequestValidation;
use App\Management\Contracts\Service\Contract;
use Illuminate\Http\Request;

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
        //Start the Robot Commands processing here

      } 

      return $response;
    }
}