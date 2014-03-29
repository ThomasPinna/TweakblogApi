<?php
	/*
	 	Copyright (c) 2014, Thomas Pinna
		All rights reserved.

		Redistribution and use in source and binary forms, with or without
		modification, are permitted provided that the following conditions are met:
    	* 	Redistributions of source code must retain the above copyright
      		notice, this list of conditions and the following disclaimer.
    	* 	Redistributions in binary form must reproduce the above copyright
      		notice, this list of conditions and the following disclaimer in the
      		documentation and/or other materials provided with the distribution.
    	* 	Neither the name of pinna nor the
      		names of its contributors may be used to endorse or promote products
      		derived from this software without specific prior written permission.

		THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
		ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
		WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
		DISCLAIMED. IN NO EVENT SHALL THOMAS PINNA BE LIABLE FOR ANY
		DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
		(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
		LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
		ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
		(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
		SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	 */
	
	require_once "reaction.php";
	
	/**
	 * A class that represents a tweakblog
	 * @author Thomas Pinna
	 */
	class TweakBlog {
		
		/// url to the blog
		private $url;
		/// title of the blog (not necessarily set)
		private $title;
		/// description of the blog (not necessarily set)
		private $descrip;
		
		/**
		 * Constructs a tweakblog object from an url
		 * @param	url		A string of the url to the page of the blog
		 * @author Thomas Pinna
		 */
		function __construct($url) {
			
			//PRECONDITIONs
			
			// check the input types
			if(!is_string($url))
				{ throw new Exception("getTweakblogs(url_name)::Argument must be a string");}
			
			//LOGIC
			
			$this->url 		= 	$url;
			$this->title 	= 	"--";
			$this->descrip	=	"--"; 
		}
		
		/**
		 * sets the title
		 * @param	a string that represents the title
		 * @author Thomas Pinna
		 */
		public function setTitle($arg){
			
			//PRECONDITIONs
			
			// check the input types
			if(!is_string($arg))
				{ throw new Exception("getTweakblogs(url_name)::Argument must be a string");}
			
			//LOGIC
			
			$this->title = $arg;
			
		}
		
		/**
		 * sets the description
		 * @param	a string that represents the description
		 * @author Thomas Pinna
		 */ 
		public function setDescription($arg){
			
			//PRECONDITIONs
			
			// check the input types
			if(!is_string($arg))
				{ throw new Exception("getTweakblogs(url_name)::Argument must be a string");}
			
			//LOGIC
			
			$this->descrip = $arg;
			
		}
		
		/**
		 * gets the title
		 * @return	a string that represents the title
		 * @author Thomas Pinna
		 */
		public function getTitle(){	return $this->title; }
		
		/**
		 * gets the description
		 * @return	a string that represents the description
		 * @author Thomas Pinna
		 */ 
		public function getDescription(){return $this->descrip;	}
		
		/**
		 * gets the contents of a file
		 * @author Thomas Pinna
		 */
		public function getBlog(){
				
			// LOGIC	
			
			// load the document			
			$test = new DOMDocument();
			@$test->loadHTMLFile($this->url);
			// find the approptiate node
			$xpath = new DOMXPath($test);
			$nodes = $xpath->query("//*[@class='article']");
			$node = $nodes->item(0); 
			// extract html from the node, by creating new domdocument
			$newdoc = new DOMDocument();
		    $cloned = $node->cloneNode(TRUE);
		    $newdoc->appendChild($newdoc->importNode($cloned,TRUE));
		    // return results
		    return $newdoc->saveHTML();
		}
		
		/**
		 * A function that returns a list of the blogs reactions
		 * @author 	Thomas Pinna
		 */
		public function getReactions(){
			
			// LOGIC
			
			// load the document			
			$test = new DOMDocument();
			@$test->loadHTMLFile($this->url); 			
			// find the approptiate nodes
			$xpath = new DOMXPath($test);
			$nodes = $xpath->query("//*[@class='reactie']");
			
			// here will we store the result
			$result = Array();
			// loop over reactions
			foreach ($nodes as $item) {
				// create an xpath so that querys can be run
				$newdoc = new DOMDocument();
		    	$cloned = $item->cloneNode(TRUE);
		    	$newdoc->appendChild($newdoc->importNode($cloned,TRUE));
				$xpath = new DOMXPath($newdoc);
				
				// get username
				// TODO instead of using these dirty hack, find the appropriate content in a nice way
				$node = $xpath->query("//*[@rel='nofollow']");
				$usr = $node->item(0)->textContent;
				// get reaction
				$node = $xpath->query("//*[@class='reactieContent']");
				$msg = $node->item(0)->textContent;
				$result[] = new TweakBlogReaction($usr, $msg);
			}
			
			return $result;
		}
		
		
		/** 
		 * A function that gets a list of blogs written by a certain user
		 * @param 	url_name	The name in the user ( url_name.tweakblogs.net leads to the homepage )
		 * 						this must be a string
		 * @return 	a list to urls to the different blogs of this user
		 * @author 	Thomas Pinna
		 */
		static public function getTweakblogs( $url_name ){
			
			// PRECONDITIONS
			
			if(!is_string($url_name))
					{ throw new Exception("getTweakblogs(url_name)::Argument must be a string");}
			
			// LOGIC
			
			// create the url
			$url = "http://".$url_name . ".tweakblogs.net/feed/";
			// load the url
			$xml=simplexml_load_file($url);
			$xml->addAttribute('encoding', 'UTF-8');
			// where to store the urls
			$result = array();
	
			//get the urls from the feed and create the Tweakblogs
			foreach ($xml->channel->children() as $value) {
				if (isset($value->guid)){
					$tempval = new TweakBlog((string)($value->guid));
					$tempval->setTitle((string)($value->title));
					$tempval->setDescription((string)($value->description)); 
					$result[] = $tempval; 
				}
			}
			
			//return your findings
			return $result;
		}
	}	
?>
