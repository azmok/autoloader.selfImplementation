<?php


namespace _Autoload;


require_once dirname(__DIR__) . "/azmok/autil/src/core.php";
require "JSON.php";


use function Autil\_, Autil\inject;




/*--------

-----------
 - resolveDependancies()
 - checkAutoloadTypes()
 - loadingFunctions()
 - loadingClassesPSR0()
 - loadingClassesPSR4()
---------*/

// relativePath: vendor/azmok/AutoLoader/src/AutoLoader.php









class Autoloader{

   static $VENDOR_DIR;
   static $PROJECT_DIR;
   static $dependancyNames = [];
   
   private $pending = [];
   private $json = null;
   private $type = "";
   private $autoload = null;
   private $filePaths = [];
   
   
   function __construct($dir){
      $this
         ->getComposerJson( $dir )
         ->getAutoloadType()
         ->getDependancies()
         
         ->register(); /**/
   }
   private function getComposerJson($pkgDir){
      // inject( "getComposerJson()", "h1" );
      $path = "{$pkgDir}/composer.json";
      $this->json = \JSON::parseFromFile($path);
      // _( $this->json );
      
      return $this;
   }
   private function getAutoloadType(){
      // inject( "getAutoloadType()" , "h3");
      $obj = $this->json;
      foreach($obj as $prop => $val){
         if( $prop === "autoload"){
            $obj2 = $this->autoload = $obj->{$prop};
            
            foreach( $obj2 as $prop => $val){
               $this->type = $prop;
            }
         }
      }
      //_ ( $this->type );
      return $this;
   }
   private function getDependancies(){
      
      $obj = $this->json;
      $pkgs = $obj->require;
      
      if( $pkgs ) {
         foreach($pkgs as $FQpkgName => $version){
            //$arr = explode("/", $FQpkgName);
            //$vendorName = $arr[0];
            //$pkgName = $arr[1];
            $path_pkg = self::$VENDOR_DIR ."/". $FQpkgName;
            // echo($path_pkg);
            
            if( in_array($FQpkgName, self::$dependancyNames) ){
               continue;
               
            } else {
               self::$dependancyNames[] = $FQpkgName;
               
               new Autoloader( $path_pkg );
            }
         }
      }
      // inject( "getDependancies()", "h3" );
      //_ ( self::$dependancyNames );
      // inject("-----", "h2");
      
      return $this;
   }
   
   function register(){
      // inject("register", "h2");
      $type = $this->type;
      
      switch( $type ){
         case "psr-0":
            
            $this->loadingClassesPSR0();
            break;
            
         case "psr-4":
            //_ ( "psr-4" );
            $this->loadingClassesPSR4();
            //   or 
            // spl_autoload_register(function(){
            //   $this->loadingClassesPSR4();
            // });
            break;
            
         case "files":
            $this->loadingFunctions();
            break;
      }
   }
   
   private function loadingFunctions(){
      // inject("loadingFunctions", "h3");
      

      $obj = $this->json;
      $packageName = $obj->name;
      $paths = $obj->autoload->files;
      $path_pkg = self::$VENDOR_DIR  ."/". $packageName;
      //_ ( $packageName, $files, $path );
         
      foreach( $paths as $path ){
         $filePath = "{$path_pkg}/{$path}";
         
         //_ ( '$filePath', $filePath );
         require_once($filePath);
      }
   }
   
   private function loadingClassesPSR0(){}
   
   private function loadingClassesPSR4(){
      // inject("loadingClassesPSR4", "h2");
      spl_autoload_register(function($name){
         //_ ( $name );
         //# (1)stlip package name
         $renamed = substr(
            $name, 
            strpos($name, '\\')+1,
            mb_strlen($name)
         );
         //_ ( "after::substr()::{$renamed}" );
         //#(2) change b-slash to f-slash
         $renamed  = preg_replace('~\\\~', '/', $renamed);
         //_ ( "after::preg_replace():: {$renamed}" );

         
         $obj = $this->json;
         $FQpkgName = $obj->name;
         $psr4 = $obj->autoload->{'psr-4'};
         $assoc = get_object_vars( $psr4 );
         
         foreach( $assoc as $namespace => $dirName){
            $path = self::$VENDOR_DIR ."/{$FQpkgName}/{$dirName}";
         }
         $path_classes = "{$path}/${renamed}.php";
         $path_traits = "{$path}/{$renamed}.php";
         $path_interfaces = "{$path}/{$renamed}.php";
         //_ ( $path_classes );
         ##3. requiring Class
         if( \is_readable( $path_classes ) ){
            require $path_classes;
            //_ ( "reqired!, {$path_classes}" );
         }
      });
   }
}