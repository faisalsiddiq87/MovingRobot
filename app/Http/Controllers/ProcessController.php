<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Management\Services\RobotService;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProcessController extends BaseController 
{
    private $service;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->service = new RobotService;
    }

    /**
     * Start the Robot Movement Process
     * 
     * @return string
     */
    public function execute($fileName) 
    {
        return $this->service->start($fileName);
    }
}