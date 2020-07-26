<?php

require_once "../vendor/autoload.php";

use function Autil\_, Autil\type, Autil\pretty;
use OOPe\Classes\AssocArrayO;




$assoc = [
   "name" => "Goku",
   "id" => "001",
];




$arr = new AssocArrayO( $assoc );
_( $arr->name ); // Goku



$arr->foo = "foo";
_( $arr->foo ); // foo



_( $arr["name"] ); // Goku

$arr->hp = "9000";
_( $arr->hp ); // 900

foreach( $arr as $key=>$val){
   _( $key, " :: ", $val);
}
/******
name :: Goku
id :: 001
********/

_( $arr );





$token = [
   "comm" => [
      "regex" => "/abc/",
      "color" => '#888',
   ],
   "str" => [
      "regex" => "/def/",
      "color" => 'yellow',
      
   ], 
   "fn" => [
      "regex" => '/ghi/',
      "color" => 'deepskyblue',
   ],
];



$token = new AssocArrayO($token);


_( $token );/*
{
   [comm]: {
      [regex]: /abc/
      [color]: #888
   }

   [str]: {
      [regex]: /def/
      [color]: yellow
   }

   [fn]: {
      [regex]: /ghi/
      [color]: deepskyblue
   }

}


_( $token->comm ); /*
{
   [regex]: /abc/
   [color]: #888
} /**


_( $token->comm->color );
// #888 /**/