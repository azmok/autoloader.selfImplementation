<?php

namespace OOPe\Classes;

/** for dev *** 
require_once dirname(__DIR__, 4)  ."/autoload.php";
/**/

use OOPe\Traits\ObjectT;
use OOPe\Classes\ArrayO;

use function Autil\_, Autil\length, Autil\type, Autil\toCamelCase, Autil\toSnakeCase, Autil\concat, Autil\trim, Autil\replace, Autil\repeat, Autil\includes, Autil\match, Autil\indexOf, Autil\inject, Autil\escape, Autil\escapeD, Autil\joinWith;



/*--------------  <<class>>  ----------------
                   StringO
---------------------------------------------
   - _value
   - _length
---------------------------------------------
   <<case change>>
   + toUpperCase() : <StringO>
   + toLowerCase() : <StringO>
   + toCamelCase() : <StringO>
   + toSnakeCase() : <StringO>
   
   <<length-change>>
   + trim() : str
   + concat( ...<Str> ) : <StringO>
   + substring( <Int>, <Int> ) : <StringO>
   + replace( <Str|RegExp>, <Str|Fn>) : <StringO>
   + split( <Int>, <Int> ) : <StringO>
   + repeat( <Int> ) : <StingO>
   
   + substitute( <Assoc> ) : <StringO>
   
   <<investigate>>
   + match( <Str|RegExp> ) : <Bool>
   + includes( <Str> ) : <Bool>
   + indexOf( <Str> ) : <Int>
   
   + pipe( <Fn> ) : <StringO>
   + inspect( <Str>, <Str> ) : <IO>
----------------------------------------------*/



class StringO implements \Iterator, \ArrayAccess{
   
   use ObjectT;
   


   private $_length = 0;
   

   
   /**
    *
    */
   function __construct($val=""){
      $this->_value = $val;
      $this->_length = length($val);
      $this->_container = str_split( $this->_value );
      
   }
   

   

   
   /**
    *
    */
   function length(){
      return $this->_length;
   }
   
   /**
    *
    */
   function toUpperCase(){
      $val = strtoupper( $this->valueOf() );
      
      return new self( $val );
   }
   
   /**
    *
    */
   function toLowerCase(){
      $val = strtolower( $this->valueOf() );
      
      return new self( $val );
   }
   
   /**
    *
    */
   function toCamelCase(){
      $val = toCamelCase( $this->valueOf() );
      
      return new self( $val );
   }
   
   /**
    *
    */
   function toSnakeCase(){
     $val = toSnakeCase( $this->valueOf() );
     
     return new self( $val );
   }
   
   
   
   /**
    *
    */
   function trim(){
      return new self( \trim($this->valueOf()) );
   }
   
   function stripSlashes(){
      return new self( \stripslashes($this->valueOf()) );
   }
   
   function htmlSpecialChars(){
      return new self( \htmlspecialchars($this->valueOf()) );
   }
   
   function validate(){
      $validated = $this
         ->trim()
         ->stripSlashes()
         ->htmlSpecialChars();
      return new self($validated->valueOf());
   }
   /**
    *
    */
   function concat(...$str){
      return new self( concat($this->valueOf(), ...$str) );
   }
   
   /**
    *
    */
   function substring($start, $len=0){
      if( !$len ){
         $len = $this->length() - 1;
      }
      $val = substr($this->valueOf(), $start, $len);
   
      return new self( $val );
   }
   
   /**
    *
    */
   function replace($searchPat, $replacePat){
      $val = replace( $searchPat, $replacePat, $this->valueOf() );
      
      return new self( $val );
   }
   
   /**
    *
    */
   function split(){
      split( $this->valueOf() );
   }
   
   /**
    *
    */
   function repeat($num){
      $val = repeat($this->valueOf(), $num);
      
      return new self( $val );
   }
   function deTemplate($assoc){
      return new self(
         strtr($this->valueOf(), $assoc) 
      );
   }

   
   /**
    *
    */
   function match($piece){
      return match( $piece, $this->valueOf() );
   }
   
   /**
    *
    */
   function includes($str){
      return includes( $str, $this->valueOf() );
   }
   
   /**
    *
    */
   function indexOf($val){
      return indexOf( $val, $this->valueOf() );
   }
   
   /**
    *
    */
   function inspect($desc="", $class=""){
      $attrAssoc = [
         "class" => " text-center $class",
         "style" => [
            "padding" => " 0.15em 0.5em 0.3em 0.5em",
            "line-height" => "1",
            "display" => "inline-block",
            "font-style" => "italic",
            "background" => "#eeeae6",
            "color" => "#444",
            "border-radius" => "8px",
            "margin-top" => "0.5em",
         ]
      ];
      
      !empty($desc) ? inject( $desc, "span") : false;
      inject('// '.  escapeD($this->valueOf()), "span", $attrAssoc);
      _( "" );
      return $this;
   }
   
   # FP 
    
   /** 
    *
    */
   function map($fn){
      $newArr = new ArrayO();
      
      foreach( $this as $char ){
         $newArr->append( $fn($char) );
      }
      
      return new self( $newArr->joinWith("") );
      

      /**********  procedural way (same result)  *******
       $newArr = [];
      
      foreach( $this as $char ){
         if( $fn($char) === true ){
            $newArr[] = $char;
         }
      }
      
      return new self( implode("", $newArr) );
      /***********************************************/
   }
   
   /** 
    *
    */
   function filter($fn){
      $newArr = new ArrayO();
      
      foreach( $this as $char ){
         if( $fn($char) === true ){
            $newArr->append( $char );
         }
      }
      
      return new self( $newArr->joinWith("") );
   }
   
   
   

   

   

   

   
   /*******  <<Iterator>>  *****
   current ( void ) : mixed
   key ( void ) : scalar
   next ( void ) : void
   rewind ( void ) : void
   valid ( void ) : bool
   /****************************/
   private $_cursor = 0;
   
   function current() {
       return $this->valueOf()[$this->_cursor];
   }
   function key(){
      return $this->_cursor;
   }
   function next(){
      $this->_cursor += 1;
   }
   function rewind(){
      $this->_cursor = 0;
   }
   function valid(){
      return $this->_cursor  <  $this->length();
   }
   

   /*--------------  <<ArrayAccess>>  --------------------
      - <Array> _container
      ----------------------------------------------------
      + offsetExists ( mixed $offset ) : bool
      + offsetGet ( mixed $offset ) : mixed
      + offsetSet ( mixed $offset , mixed $value ) : void
      + offsetUnset ( mixed $offset ) : void
    /*----------------------------------------------------*/
    
    # this property is initliazed by __construc()
    private $_container;
    
    function offsetExists($offset){
       _("offsetExists");
    }
    function offsetGet($offset){
       return $this->_container[$offset];
    }
    function offsetSet($offset ,$value){
       $this->_container[$offset] = $value;
       $this->_value = joinWith("", $this->_container);
    }
    function offsetUnset($offset){
       _( "unset");
    }
    

    

   //  function __toString(){
   //    return $this->valueOf(); // Number, String, Regex
   // }
}

/*
function StringO($v){
   return new StringO($v);
}

$userInput = "<script>alert('hi')</script> amp: & bslash: \ ";

$str = (new StringO($userInput))
   ->trim()
   ->stripSlashes()
   ->htmlSpecialChars();

//_( $str );
//_( $str->valueOf() );
_( 
   (new StringO($userInput))
      ->validate()
      ->valueOf()
);/**/
















