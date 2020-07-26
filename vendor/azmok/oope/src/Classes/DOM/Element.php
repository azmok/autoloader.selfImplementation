<?php

namespace OOPe\Classes\DOM;

use function Autil\_, Autil\type, Autil\escapeHTML, Autil\render, Autil\joinWith;

use OOPe\Traits\ObjectT;

/*---------
   Element
-----------
 
-----------
 
----------*/

class Element extends \DOMElement{
   
   use ObjectT;
   
   function __construct($tagName, $val=""){
      parent::__construct($tagName, $val);
   }
   
   function html(...$args){
      # get
      if( empty($args) ){
         $html = "<". $this->tagName .">".  $this->textContent
                 ."</". $this->tagName .">";
         return $html;
         
      # ser
      } else {
         $str = $args[0];
         $matched = match('~<(.+)(\s.+)*?>(.*)</\1>~', $str);
         $tagName = matched[0];
         $attrs = matched[1];
         $txt = matched[2];
         
         $newElm = new Element($tagName);
         //$newElm->setAttribute();
         $newElm->textContent = $txt;
         # appned DOMTree
         $parent = $this->parentNode;
         $parent->replaceChild($newElm, $this);
         
         return $newElm;
      }
   }
   
   function text(...$args){
      # get
      if( empty($args) ){
         return $this->textContent;
      
      # set
      } else {
         $this->textContent = $args[0];
         
         return $this;
      }
   }
   
   function css($assoc){
      $attr = "style";
      $valArr = joinWith(":", $assoc);
      $val = joinWith("; ", $valArr);
      
      $this->setAttribute($attr, $val);
      
      return $this;
   }
   
   function append($el){
      $this->appendChild($el);
      
      return $this;
   }
   
   function appendTo($el){
      $el->appendChild($this);
      
      return $this;
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
   

}


















