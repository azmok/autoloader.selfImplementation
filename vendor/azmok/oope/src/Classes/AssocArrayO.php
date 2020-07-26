<?php

namespace OOPe\Classes;



use OOPe\Traits\AssocArrayT;


use function Autil\_, Autil\type, Autil\prettify, Autil\pretty, Autil\isAssoc, Autil\isArray, Autil\length,
Autil\loadCss, Autil\loadJs, Autil\escape,

Autil\contain, Autil\concat, Autil\prependTab, 
Autil\head, Autil\indexOf, Autil\_forEach, Autil\append, Autil\merge, Autil\some, Autil\every, Autil\isOneDimensional, 
Autil\object2String, 
Autil\inject, Autil\render;



/*-------------------------
    assocArrayO
---------------------------
   - <Arr> _value = [];
   - <Num> _length = 0;
   - <Num>_cursor = 0;
   - <Arr> _keysArr = []
   - <Arr> _container = []
----------------------------
   <<ObjectT>>
   <<ArrayT>>
   
   value()
   length()
   
   concat()
   indexOf()
   map()
   filter()
   reduce()
/*-------------------------*/



class AssocArrayO implements \ArrayAccess, \Iterator {
   
   use AssocArrayT;
   
   
   private $_cursor = 0;
   private $_keysArr = [];


   
   function __construct($assoc, $flags=0){
      # 
      if( $assoc === null || empty($assoc) ){
         return;
      }
      
      ### set $_length, 
      $this->_length = count($this->_keysArr);
      ### set readOnky prop
      $this->length = $this->_length;

      
      ## if $val is AsscoArr, recursively set $val as 'AssocArrayO'
      if( isOneDimensional($assoc) ){
         ### assing key to object' prop
         foreach($assoc as $key=>$val){
            
            ## for <<iterator>> initialize
            $this->_keysArr[] = $key;
            
            ## initializing for <<ArrayAccess>>
            $this->_value[$key] = $val;
            
            # iniitlizeing object key-val
            $this->$key = $val;
            //_( $key, $this->$key );
         }
         
        
      ### multi dimensional assoc
      } else {
      
         foreach($assoc as $key=>$val){
            //_( $key, $val );
            
            ## for <<iterator>> initialize
            $this->_keysArr[] = $key;
            
            ### $val: isAssoc
            if( isAssoc($val) ){
               # initializing for <<ArrayAccess>>
               $this->_value[$key] = new AssocArrayO($val);
               
               # initlizeing object key-val
               $this->$key = new self($val);
         
            ### $val: no Assoc
            } else {
               ## initializing for <<ArrayAccess>>
               $this->_value[$key] = $val;
               
               ## # initlizeing object key
               $this->$key = $val;
            }
         }
      }
   }

   
   
   /*--------------  <<ArrayAccess>>  --------------------
      - <Array> _container
      ----------------------------------------------------
      + offsetExists ( mixed $offset ) : bool
      + offsetGet ( mixed $offset ) : mixed
      + offsetSet ( mixed $offset , mixed $value ) : void
      + offsetUnset ( mixed $offset ) : void
   /*----------------------------------------------------*/
   function offsetExists($offset){
      _("in offsetExists");
   }
   function offsetGet($offset){
      //_( "in offsetGet");
      return $this->_value[$offset];
   }
   function offsetSet($offset ,$value){
      //_( "in offsetSet" );
      $this->_value[$offset] = $value;
   }
   function offsetUnset($offset){
      _( "unset");
   }
   
   
   
   /*******  <<Iterator>>  *****
      current ( void ) : mixed
      key ( void ) : scalar
      next ( void ) : void
      rewind ( void ) : void
      valid ( void ) : bool
   /****************************/
   function current() {
      //_( "in current()" ); 
      $key = $this->_keysArr[$this->_cursor];
      $val = $this->_value[$key];
      
      return $val;
   }
   function key(){
      //_( "in key()" ); 
      $key = $this->_keysArr[$this->_cursor];
      //_("key",  $key );
      return $key;
   }
   function next(){
      //_( "in next()" ); 
      $this->_cursor += 1;
   }
   function rewind(){
      //_( "in rewind()" ); 
      $this->_cursor = 0;
   }
   function valid(){
      //_( "in valid()" ); 
      return $this->_cursor  <  $this->_length;
   }
   
   function  __toString(){
      return object2String($this); // Array, AssocArray, 
      //return (string) $this->valueOf(); // Number, Sting, Regex
      //return type($this); // Function, DOMDoc, DOMElm, 
   }
}



























