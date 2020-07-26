<?php

namespace OOPe\Classes;



use OOPe\Traits\ObjectT;

use function Autil\_, Autil\type;



/*--------------------
      DOMElm
----------------------

----------------------


--------------------*/



class DOMElm extends \DOMElement{
   
   use ObjectT;
   

   
   function __construct($tagName){
      parent::__construct($tagName);
   }
   
   
   
   
   
   function attr(...$args){
      # get
      if( empty($args) ){
         return $this->getAttribute();
      
      # set
      } else {
         $name = $args[0];
         $val = $args[1];
         
         $this->setAttribute($name, $val);
         
         return $this;
      }
   }
   
   function append($elm){
      $this->appendChild($elm);
      
      return $this;
   }
   
   function appendTo($target){
      $target->appendChild($this);
      
      return $this;
   }
   
   function text(...$str){
      # get
      if( empty($str) ){
         return $this->textContent;
      # set
      } else {
         $this->textContent = $str[0];
         
         return $this;
      }
   }
}
















