<?php


namespace Autoloader;




function polifill_dirname(){
   $rf = new \ReflectionFunction('\dirname');
   $params = $rf->getParameters() ;
   
   if( count( $params ) === 1 ){
      function dirname($path, $depth=1){
         while($depth > 0){
            $path = substr($path, 0, strrpos($path, "/"));
            //echo "{$path}<br>";
            $depth--;
         }
         return $path;
      }
   }
}
polifill_dirname();




# vendor/azmok/autoloader/src/Autoloader.php
$vendorDir = dirname( __FILE__, 4);
require_once $vendorDir ."/azmok/autil/src/core.php";
require "JSON.php";

use function Autil\_, Autil\inject;





/*--------
   Autoloader
-----------*
 + __construct
 - getComposerJsonObject
 - getAutoloadType
 - getDependancies
 - register
 - loadingFunctions
 - loadingClasses_PSR0
 - loadingClasses_PSR4
---------*/




class Autoloader{

   static $dependancyNames = [];
   static $VENDOR_DIR = "";
   
   private $packageDir = "";
   private $json = null;
   private $type = "";
   private $autoload = null;
   
   
  
   function __construct( $pkgDir="" ){
      # first initialization in 'vendor/autoload.php'
      # need to access 'rootPkg/composer.json'
      if( empty($pkgDir) ){
         global $vendorDir;
         
         _( $vendorDir );
         $this->packageDir = dirname( $vendorDir );
      } else {
         $this->packageDir = $pkgDir;
      }
      
      $this
         ->getComposerJsonObject()
         ->getAutoloadType()
         ->getDependancies()
         ->register();
   }
   
   private function getComposerJsonObject(){
      inject( "getComposerJsonObject()", "h1" );
      $pkgPath =  $this->packageDir ."/composer.json";
      $this->json = \JSON::parseFromFile($pkgPath);
      _( $this->json );
      
      return $this;
   }
   
   private function getAutoloadType(){
      // ### Autil(finction files)
      // {
      //    "name": "azmok/autil",
      //    "autoload": {
      //       "file": []
      //    }
      // }
      //
      // 
      // ### OOPe(class files)
      // {
      //    "name": "azmok/oope",
      //    "autoload": {
      //       "psr-4: {
      //          "OOPe\\": "src"
      //       }
      //    }
      // }
      inject( "getAutoloadType()" , "h3");
      $json = $this->json;
      
      foreach($json as $prop => $val){
         if( $prop === "autoload"){
            _(3);
            $json2 = $json->{$prop};
            $this->autoload = $json->{$prop};
            
            foreach( $json2 as $prop => $val){
               $this->type = $prop;
            }
         }
      }
      
      _( $this->type );
      return $this;
   }
   
   private function getDependancies(){
      inject( "==== getDependancies() ====>", "h3" );
      $json = $this->json;
      $pkgs = $json->require;
      
      if( $pkgs ) {
         foreach($pkgs as $pkgName => $version){
           
            $path_pkg = self::$VENDOR_DIR ."/". $pkgName;
            _( "<b>package path</b>" );
            _( $path_pkg );
            
            if( in_array($pkgName, self::$dependancyNames) ){
               continue;
               
            } else {
               self::$dependancyNames[] = $pkgName;
               
               new Autoloader( $path_pkg );
            }
         }
      }
      
      
      _( self::$dependancyNames );
      inject("<====  getDependancies() ====//", "h3");
      
      return $this;
   }
   
   private function loadingFunctions(){
      inject("loadingFunctions", "h3");
      

      $obj = $this->json;
      $packageName = $obj->name;
      $paths = $obj->autoload->files;
      $path_pkg = self::$VENDOR_DIR  ."/". $packageName;
      
      _( $packageName, $files, $path );
         
      foreach( $paths as $path ){
         $filePath = "{$path_pkg}/{$path}";
         
         _( '$filePath', $filePath );
         
         require_once($filePath);
      }
   }
   
   private function loadingClasses_PSR0(){}
   
   private function loadingClasses_PSR4(){
      inject("loadingClasses_PSR4", "h2");
      spl_autoload_register(function($name){
      
         _( $name );
         
         //### (1)stlip package name
         $fileName = substr(
            $name, 
            strpos($name, '\\') + 1,
            mb_strlen($name)
         );
         _( "after::substr()::{$fileName}" );
         

         //### (2)change b-slash to f-slash
         $fileName2 = preg_replace('~\\\~', '/', $fileName);
         _( "after::preg_replace():: {$fileName2}" );

         
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
         _( $path_classes );
         
         ##3. requiring Class
         if( \is_readable( $path_classes ) ){
            require $path_classes;
            _( "reqired!, {$path_classes}" );
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
Autoloader::$VENDOR_DIR = $vendorDir;