<?php

namespace OOPe\Classes;



use OOPe\Traits\ObjectT;

use function Autil\_, Autil\filter, Autil\concat, Autil\joinWith, Autil\match, Autil\splitWith, Autil\pretty, Autil\toArray, Autil\replace;


/*-----------------------------------
|       RegExp
-------------------------------------
   - "" _value
   - "" _pattern
   - [] _flags
-------------------------------------
   + pattern() : ""
   + flags() : []
   + setFlags : {}
   + filterFlags() : {}
   + exec() : ""
   + replace() : ""
   
   // '::' indicates static method.
   ::getRegex() : ""
   ::getFlags() : []
-----------------------------------*/

class RegExpO{

   use ObjectT;

   
   private $_value = "";
   private $_pattern = "";
   private $_flags = [];
   
   
   
   function __construct($str){
      $this->_value = $str;
      $this->_pattern = self::getRegex($str);
      $this->_flags = self::getFlags($str);
   }
   

   

   
   /***
   * Return string of regex
   */
   function pattern(){
      return $this->_pattern;
   }
   
   /***
   * Return array of flags
   */
   function flags(){
      return $this->_flags;
   }
   
    
   function setFlags($str){
      $pat = $this->pattern();
      $flagsArr = $this->flags();
      _( $flagsArr );
      $flagsStr = joinWith("", $flagsArr);
      _( $flagsStr );
      //$filter
   }
   
   
   function filterFlags($str){
      $arr = toArray($str);
      $flags = $this->flags();
      $filtered = array_diff($flags, $arr);
      //_( $arr, $flags);
      //_("diff:", $filtered);
      $regex = $this->pattern();
      //_( $this->regex() );
      //_( $regex );
      $newRegex = concat($regex, joinWith("", $filtered));
      //_( $newRegex );
      return new RegExpO( $newRegex );
   }
   
   /*** exec($str)
   * summary
   * description
   @param
       String $str : param description
   ***/
   function exec($str){
      return match($this->_value, $str);
   }
   
   function replace($fn, $str){
      return replace($this->_value, $fn, $str);
   }
   
   
   
   
   #####  Static Method  ####
   ## ::getFalgs
   static function getFlags($str){
      $regex = '#^(\W)([\w\W]*?)\1(\w*)$#';
      
      preg_match($regex, $str, $matches);
      
      $flagArr = splitWith("", $matches[3]);
      
      return $flagArr;
   }
   
   ## ::getRegex
   static function getRegex($str){
      $regex = '#^(\W)([\w\W]*?)\1(\w*)$#';
      
      preg_match($regex, $str, $matches);
      
      return $matches[1] . $matches[2] . $matches[1];
   }
   
   function __toString(){
      return (string) $this->valueOf(); // Number, String, Regex
   }
   
}



























