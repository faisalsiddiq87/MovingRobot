<?php

namespace App\Management\Services;

use App\Management\Contracts\Service\Contract;
use Illuminate\Http\Request;

class SquareTableService implements Contract
{
   private $xAxis;

   private $yAxis;

   public function __construct($x, $y)
   {
      $this->xAxis = $x;

      $this->yAxis = $y;
   }

   public function getMaxXAXIS() 
   {
      return $this->xAxis;
   }

   public function getMaxYAXIS() 
   {
      return $this->yAxis;
   }

   public function isValidSquareTable()
   {
      $isSquare = false;

      if ($this->getMaxXAXIS() == $this->getMaxYAXIS() && $this->getMaxXAXIS() > 0 &&  
      $this->getMaxYAXIS() > 0) {
         $isSquare = true;
      }

      return $isSquare;
   }

   public function isValidLocationOnTable($x, $y)
   {
      $isValidMove = false;

      if ($x <= $this->getMaxXAXIS() && $y <= $this->getMaxYAXIS()) {
         $isValidMove = true;
      }

      return $isValidMove;
   }
}