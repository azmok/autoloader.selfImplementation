<?php



namespace OOPe\Interfaces;



interface ArrayInterface{
   function value();
   function length();
   
   function concat($val);
   function indexOf($val);
   
   function map($fn);
   function filter($fn);
   function reduce($fn, $initVal=[]);
}