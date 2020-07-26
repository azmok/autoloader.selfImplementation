<?php

namespace OOPe\Classes;



use OOPe\Traits\ArrayT;

use function Autil\_, Autil\pretty, Autil\isArray, Autil\object2String;



/*--------------
   ArrayO
----------------
   - <Array> value
   - <Integer> length
   - <Integer> cursor
----------------
   <<ObjectT>>
   <<ArrayT>>
   
   + append() : <Obj>
   + prepend() : <Obj>
   + length() : <Int>
   
   + concat() : <Array>
   + indexOf() : <Int>
   
   + map() : <Array>
   + filter() : <Array>
   + reduce() : <Array>
   

   + inspect() : Void
   + extract() : <Mixed>

   <<Arrayiterator>>
   + current
   + key
   + next
   + rewind
   + valid
------------------*/



class ArrayO extends \ArrayIterator{
   
   use ArrayT;
   

   
   function __construct($val=[], $flags=0){
      # type check of $val
      if( isArray($val) ){
         parent::__construct($val, $flags);
         
         $this->_value = $val;
         $this->_length = count($val);
         
         # setting object prop
         $this->length = $this->_length;
         
         
      } else {
         throw new \Exception("Invalid type of arguments in ArrayO");
      }
   }
   
}


















