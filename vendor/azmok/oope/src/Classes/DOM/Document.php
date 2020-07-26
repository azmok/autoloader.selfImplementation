<?php

namespace OOPe\Classes\DOM;

use function Autil\_, Autil\type;

use OOPe\Traits\ObjectT;

/*--------------
   Document
----------------

 - doc
 - head
 + body
 -prismCss1
 -prismCss2
 
-----------------

  <<ObjectT>>

   + html
   + create
  (+ createElement )// overwritten
   + appendJs
   + appendCss
   + render
   + exportHTML

   - setViewport
   + init
 

   __toString()
   
----------------*/

class Document extends \DOMDocument {

   use ObjectT;
   
   
      
   public $body;
   
   private $document;
   private $head;
   /*-----------  Prism.js: CDN(autoload)  ---------*/
   private $prismCss = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/themes/prism-okaidia.min.css';
   private $prismJs1 = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/components/prism-core.min.js';
   private $prismJs2 = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/plugins/autoloader/prism-autoloader.min.js';
   /*----  Bootstrup.css ----*/
   private $URL_BOOTSTRUP_CDN = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css";
   /*-----------*/

   

   function __construct(){
      parent::__construct();
      
      # doc seed
      $di = new \DOMImplementation();
   
      # set !doctype
      $docTypeObj = $di->createDocumentType("html");
   
      # instanciate document object
      $doc = $di->createDocument("", "html",$docTypeObj);
   
      # ser formatting
      $doc->formatOutput = true;
   
      # set head, body
      $head = $this->create("head");
      $body = $this->create("body");
      $html = $doc->documentElement;
      $html->appendChild($head);
      $html->appendChild($body);
      
      # set -- $doc, ++body
      $this->head = $head;
      $this->body = $body;
      $this->document = $doc;
   }
   
   function create($tagName, $val=""){
      return new Element($tagName, $val);
   }
   function createElement($tagName, $val=""){
      return new Element($tagName, $val);
   }
   
   function html(...$args){
      //return escapeHTML($this->doc->saveHTML());
      return $this->document->saveHTML();
   }
   
   function exportHTML($fileName){
      $this->document->saveHTMLFile($fileName);
   }
   
   function render(){
      echo $this->html();
   }
   
   private function setViewport(){
      $this
         ->create('meta')
         ->appendTo( $this->head )
         ->attr('name', 'viewport')
         ->attr('content', 'width=device-with, initial-scale=1');
   }
   
   function appendCss($path){
      $this
         ->create('link')
         ->appendTo( $this->head )
         ->attr('rel', 'stylesheet')
         ->attr('href', $path);
   }
   
   function appendJs($path){
      $this
         ->create('script')
         ->appendTo( $this->body )
         ->attr('src', $path);
   }
   
   function init(){
      $this->setViewport();
      
      # Bootstrup.css
      $this->appendCss($this->URL_BOOTSTRUP_CDN);
      
      # Prism.css/js
      $this->appendCss($this->prismCss);
      $this->appendJs($this->prismJs1);
      $this->appendJs($this->prismJs2);
      
      # add paddign to body
      $this->body->setAttribute("style", "padding: 1rem;");
      
      return $this;
   }
   
   function __toString(){
      return $this->html();
   }
   
   
}











