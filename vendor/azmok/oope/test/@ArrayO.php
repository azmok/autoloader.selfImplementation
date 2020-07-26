<?php


require_once "../vendor/autoload.php";

use function Autil\_, Autil\type, Autil\pretty;
use OOPe\Classes\ArrayO;





$arr = new ArrayO( [1,2,3] );

_( $arr );



/*



echo $arr;
// {
//    [0]: 1
//    [1]: 2
//    [2]: 3
// }


_( $arr );
// {
//    [0]: 1
//    [1]: 2
//    [2]: 3
// }


### Array access
_( $arr[0] ); // 1
_( $arr[1] ); // 2
_( $arr[2] ); // 3

//_( $arr[3] ); // [Null]




#### foreach()
foreach( $arr as $key=>$val){
   _( "{$key} ::: {$val}" );
}

// 0 ::: 1
// 1 ::: 2
// 2 ::: 3






_( $arr->length ); // 3
//$arr->length = 999; // !Error!


_( $arr->getProps() ); // (0,1,2)

pretty( $arr->getMethods() ); /*

[0]: offsetExists
[1]: offsetGet
[2]: offsetSet
[3]: offsetUnset
[4]: append
[5]: getArrayCopy
[6]: count
[7]: getFlags
[8]: setFlags
[9]: asort
[10]: ksort
[11]:  
[15]: unserialize
[16]: serialize
[17]: rewind
[18]: current
[19]: key
[20]: next
[21]: valid
[22]: seek
[23]: ObjectTConstruct
[24]: __get
[25]: __set
[26]: valueOf
[27]: getClassName
[28]: getNamespace
[29]: getProps
[30]: getMethods
[31]: __toString
[32]: prepend
[33]: indexOf
[34]: concat
[35]: merge
[36]: joinWith
[37]: map
[38]: filter
[39]: reduce
[40]: inspect  /**/

/*
_( get_object_vars($arr) ); // (1,2,3)


/**/


