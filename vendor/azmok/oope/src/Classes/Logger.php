<?php

namespace OOPe\Classes;



use function Autil\_, Autil\indexOf, Autil\concat, Autil\isAssoc, Autil\isArray, Autil\_forEach, Autil\head, Autil\contain, Autil\pretty, Autil\append, Autil\prettify, Autil\match, Autil\type;




/*--------------------
        Logger
  (wrapper logging class)
----------------------

----------------------


--------------------*/



class Logger{

   private $_obj;
   private $_info = [];
   

   
   function __construct($obj, $notify=true){
      $this->_obj = $obj;
      $this->log();
      $this->_notify = $notify;
   }
   

   

   
   function __call($name, $args){
      # @param
      #   | Str $name : called method name
      #   | []  $args : array of arguments with wchich the method called
      # 
      if( !empty($name) ){
         $this->_info = [
            "Caller" => $name,
            "Args" => $args,
            "CurrentVal" => "",
         ];
      }

      if( method_exists($this->_obj, $name) ){
         $class = new \ReflectionClass('\OOPe\Classes\StringO');
         //_( "isInstance::", $class->isInstance($this->_obj) );
         
         # set wrapped object '$_obj'
         $this->_obj = ($this->_obj)->$name(...$args);
         
         # set return in '$this->_info'
         $this->_info['CurrentVal'] = $this->_obj;
         //_( ($this->_obj)->$name(...$args) );
         /*
         _( $name );
         _( ...$args );
         _( $this->_obj ); /**/
         
      }
      
      ## inject log info to HTML
      if( $this->_notify ){
         _( $this->_info );
      }
      
      return $this;
   }
   
   /** return wrapped object
    *
    */
   function __toString(){
      return $this->_obj;
   }
}










































