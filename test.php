<?php


require  "vendor/autoload.php";


use function Autil\_;
use OOPe\Classes\ArrayO;



_(1);
_( new ArrayO() );
_(
  ( new ArrayO([1,2,3,4,5]) )
    ->length
);