<?php


namespace Autoloader;


require_once dirname(__DIR__) . "/azmok/autil/src/core.php";
require "JSON.php";


use function Autil\_, Autil\inject;





/*--------
   Autoloader
-----------
 + __construct
 - getComposersJson
 - getAutoloadType
 - getDependancies
 - register
 - loadingFunctions
 - loadingClasses_PSR0
 - loadingClasses_PSR4
---------*/

class Autoloader{

   static $VENDOR_DIR = "";
   static $PROJECT_DIR = "";
   static $dependancyNames = [];
   
   private $json = null;
   private $type = "";
   private $autoload = null;
   
   
   
   function __construct(){
      $this
         ->getComposersJson()
         ->getAutoloadType()
         ->getDependancies()
         ->register();
   }
   
   private function getComposersJson(){
      // inject( "getComposersJson()", "h1" );
      $path = "{$PROJECT_DIR}/composer.json";
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
         foreach($pkgs as $pkgName => $version){
            //$arr = explode("/", $pkgName);
            //$vendorName = $arr[0];
            //$pkgName = $arr[1];
            $path_pkg = self::$VENDOR_DIR ."/". $pkgName;
            // echo($path_pkg);
            
            if( in_array($pkgName, self::$dependancyNames) ){
               continue;
               
            } else {
               self::$dependancyNames[] = $pkgName;
               
               new Autoloader( $path_pkg );
            }
         }
      }
      // inject( "getDependancies()", "h3" );
      //_ ( self::$dependancyNames );
      // inject("-----", "h2");
      
      return $this;
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
   
   private function loadingClasses_PSR0(){}
   
   private function loadingClasses_PSR4(){
      // inject("loadingClasses_PSR4", "h2");
      spl_autoload_register(function($name){
         //_ ( $name );
         
         //### (1)stlip package name
         $fileName = substr(
            $name, 
            strpos($name, '\\')+1,
            mb_strlen($name)
         );
         //_ ( "after::substr()::{$fileName}" );
         
         //### (2)change b-slash to f-slash
         $fileName2  = preg_replace('~\\\~', '/', $fileName2);
         //_ ( "after::preg_replace():: {$fileName2}" );

         
         $obj = $this->json;
         $pkgName = $obj->name;
         $psr4 = $obj->autoload->{'psr-4'};
         $assoc = get_object_vars( $psr4 );
         
         foreach( $assoc as $namespace => $dirName){
            $path = self::$VENDOR_DIR ."/{$pkgName}/{$dirName}";
         }
         $path_classes = "{$path}/${fileName2}.php";
         $path_traits = "{$path}/{$fileName2}.php";
         $path_interfaces = "{$path}/{$fileName2}.php";
         //_ ( $path_classes );
         ##3. requiring Class
         if( \is_readable( $path_classes ) ){
            require $path_classes;
            //_ ( "reqired!, {$path_classes}" );
         }
      });
   }
   
   private function register(){
      // inject("register", "h2");
      $type = $this->type;
      
      switch( $type ){
         case "psr-0":
            
            $this->loadingClasses_PSR0();
            break;
            
         case "psr-4":
            //_ ( "psr-4" );
            $this->loadingClasses_PSR4();
            //   or 
            // spl_autoload_register(function(){
            //   $this->loadingClasses_PSR4();
            // });
            break;
            
         case "files":
            $this->loadingFunctions();
            break;
      }
   }
   
}