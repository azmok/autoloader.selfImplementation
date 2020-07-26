<?php

namespace OOPe\Classes;



use OOPe\Traits\ObjectT;
use OOPe\Classes\DOMElm;

use function Autil\_, Autil\type, Autil\escapeHTML, Autil\render, Autil\pretty;



/*--------------------
      DOMDoc
----------------------

----------------------


--------------------*/



class DOMDoc extends \DOMDocument{
   
   use ObjectT;
   

   private $_html;
   private $_head;
   private $_body;
   

   
   function __construct(){
      # parent
      parent::__construct();
      
      # Initalization
      
      $html = $this->_html = $this->create('html');
      $head = $this->_head = $this->create('head');
      $body = $this->_body = $this->create('body'); 
       
      #   top-most element that is instanciated by '$this->create()' must be appneded 
      #  first to $this(DOMDocument instance)!!
      #
      #   Created elements($html, $head, $body) are instance of DOMElm class,
      #  its parent is DOMElement class, thus, it's read-only until appneded to 
      # doument tree.
      $this->appendChild($html);
      
      $html->appendChild($head);
      $html->appendChild($body);
      
      /*******  debug  *****
      _( $this ); // [object DOMDoc]
      
      render(
         escapeHTML($this->saveHTML()),
         "pre"
      );
      /*******/
   }
   
   
   
   
   
   function init(){
      
      $this->setViewport();
      
      /*-----------  Prism.js: CDN(autoload)  ---------*/
      $prismCss = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/themes/prism-okaidia.min.css';
      $prismJs1 = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/components/prism-core.min.js';
      $prismJs2 = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/plugins/autoloader/prism-autoloader.min.js';
      /*----  Bootstrup.css ----*/
      $URL_BOOTSTRUP_CDN = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css";
      /*-----------*/

      
      # Bootstrup.css
      $this->appendCss($URL_BOOTSTRUP_CDN);
      
      # Prism.js
      $this->appendCss($prismCss);
      $this->appendJs($prismJs1);
      $this->appendJs($prismJs2);
      
      # add paddign to body
      $this->_body->setAttribute("style", "padding: 1rem;");
      
      /*----------------------------------------------*/
      
      return $this;
   }
   
   function create($tagName){
      return new DOMElm($tagName);
   }
   
   function render(){
      echo $this->saveHTML();
   }
   
   function html(){
      return escapeHTML( $this->saveHTML() );
   }
   
   function setViewport(){
      $this
         ->create('meta')
         ->appendTo( $this->_head )
         ->attr('name', 'viewport')
         ->attr('content', 'width=device-with, initial-scale=1');
   }
   
   function appendCss($path){
      $this
         ->create('link')
         ->appendTo( $this->_head )
         ->attr('rel', 'stylesheet')
         ->attr('href', $path);
   }
   
   function appendJs($path){
      $this
         ->create('script')
         ->appendTo( $this->_body )
         ->attr('src', $path);
   }
   

   function __get($val){
      _( "__get() fired!");
      _( "_{$val}" );
      _( $this->{"_{$val}"} );
      
      if( $this->{"_{$val}"} ){
         
         return $this->{"_{$val}"};
      }/**/
   }
   
}






















