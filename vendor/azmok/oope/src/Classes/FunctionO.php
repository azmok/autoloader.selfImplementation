<?php

namespace OOPe\Classes;



use OOPe\Traits\ObjectT;

use function Autil\_, Autil\type, Autil\call, Autil\apply, Autil\bind, Autil\curry, Autil\concat, Autil\splitNamespaces;



/*--------------------
   FunctionO
----------------------
   length()
   name()
-----------------------
   call()
   apply()
   bind()
   toString()

   _Function::curry

---------------------*/



class FunctionO{

   use ObjectT;
  

   private $_value;
   private $_length;
   private $_name;
   

   
   function __construct($fn, $currying=false){
      $this->_length = (new \ReflectionFunction($fn))->getNumberOfParameters();
      
      if( $currying === true ){
         $this->_value = self::curry( $fn );
      } else {
         $this->_value = $fn;
      }
      $this->_name = (new \ReflectionFunction($fn))->getName()  ."\0";
   }
   

   

   
   ## magic __invoke
   function __invoke(...$args){
      return ($this->_value)( ...$args );
   }
   
   ## name
   function name(){
      return new StringO( $this->_name );
   }
   
   ## call
   function call($obj, ...$args){
      return call( $this->_value, $obj, ...$args );
   }
   
   ## apply
   function apply($obj, $arr){
      return apply( $this->_value, $obj, $arr );
   }
   
   ## bind
   function bind($obj, ...$args){
      _( $this->_value );
      _( type($obj) );
      return new self( bind( $this->_value, $obj, ...$args ) );
   }
   
   ## FunctionO::curry
   static function curry($fn, ...$args){
      return curry($fn, ...$args);
   }
   

   
   
}























