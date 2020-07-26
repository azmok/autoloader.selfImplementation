<?php


require_once "../vendor/autoload.php";

use function Autil\_, Autil\type, Autil\pretty;
use OOPe\Classes\DOM\Document;
use OOPe\Classes\DOM\Element;


$doc = new Document();
$body = $doc->body;



# add div *2
$d1 = $doc
   ->create("div")
   ->appendTo($body) // !must be appneded 'first' in PHP. If not, error thwown.
   ->text("hi")
   ->css([
      "color" => "blue",
      "font-weight" => "700",
   ]);
   
$d2 = $doc
   ->create("div")
   ->appendTo($body)
   ->text("woo");


$doc->render();

/**/




















