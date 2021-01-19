<?php



class JSON {
   
   static function parse($str){
      return json_decode($str);
   }
   
   static function parseFromFile($path){
      $jsonStr = file_get_contents($path);
      $jsonObj = json_decode($jsonStr);
   
      return $jsonObj;
   }
   
}