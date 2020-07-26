<?php


require_once "../vendor/autoload.php";

use function Autil\_, Autil\type, Autil\pretty;
use OOPe\Classes\ObjectO;


$obj = new ObjectO();
_( $obj->getProps() );
_( $obj->getMethods() );


$obj = new ObjectO([
   "name" => "azu",
   "id" => "001",
]);
_( $obj->name );
_( $obj->id );

$obj2 = new ObjectO([
   "name" => "maru",
   "type" => [
      "gender" => "male",
      "blood" => "type-O",
      "invalid-prop" => "propVal",
   ],
]);

_( $obj2->name ); // "maru"
_( $obj2->type->gender ); // "male"
_( $obj2->type->blood ); // "type-O"
_( $obj2->type->{'invalid-prop'}); // "propVal"


_( $obj2 );