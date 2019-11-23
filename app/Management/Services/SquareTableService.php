<?php

namespace App\Management\Services;

use App\Management\Contracts\Service\Contract;

class SquareTableService implements Contract
{
   private $xAxis;

   private $yAxis;

   public function __construct($x, $y)
   {
      $this->xAxis = $x;

      $this->yAxis = $y;
   }

   private function getMaxXAXIS() 
   {
      return $this->xAxis;
   }

   private function getMaxYAXIS() 
   {
      return $this->yAxis;
   }

   public function isValidSquareTable()
   {
      $isSquare = false;

      $xAxis = $this->getMaxXAXIS();

      $yAxis = $this->getMaxYAXIS();

      if ((ctype_digit($xAxis) && ctype_digit($yAxis)) && ($xAxis == $yAxis) && 
      ($xAxis > 0 &&  $yAxis > 0)) {
         $isSquare = true;
      }

      return $isSquare;
   }

   public function isValidLocationOnTable($newXAxis, $newYAxis)
   {
      $isValidMove = false;

      if (($newXAxis < $this->getMaxXAXIS() && $newYAxis < $this->getMaxYAXIS())
      && ($newXAxis >=0 && $newYAxis >= 0)) {
         $isValidMove = true;
      }

      return $isValidMove;
   }
}