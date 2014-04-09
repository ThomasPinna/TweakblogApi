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
	
	namespace TweakblogAPI;
	
	require_once "TweakBlogReaction.php";
	require_once "BlackWhiteList.php";

	use DOMDocument;
	use DOMXPath;
	use SimpleXMLElement;
	use Exception;
	
	/**
	 * A class that represents a tweakblog
	 * @author Thomas Pinna
	 * @author Sebastiaan Franken (helped with codecleaning)
	 */
	class TweakBlog {
		
		/// string: url to the blog
		private $url;
		/// string: title of the blog (not necessarily set)
		private $title;
		/// string: description of the blog (not necessarily set)
		private $descrip;
		/// string:	the author of this blog
		private $author;
		
		/**
		 * Constructs a tweakblog object from an url
		 * @author 	Thomas Pinna
		 * @param	string: url to the blog
		 * @param	string:	title of the blog (optional)
		 * @param	string:	title of the blog (optional)
		 */
		function __construct($url, $title ="", $descrip="") {
			
			//PRECONDITIONs
			
			// check the input types
			if(!is_string($url))
				{ throw new Exception("TweakBlog::__construct: first argument must be a string");}
			if(!is_string($title))
				{ throw new Exception("TweakBlog::__construct: second argument must be a string");}
			if(!is_string($descrip))
				{ throw new Exception("TweakBlog::__construct: thirs argument must be a string");}
			
			//LOGIC
			
			$this->url 		= 	$url;
			preg_match("#http://(.*?)\.tweakblogs.net#s", $url, $this->author);
			$this->author = $this->author[1];
			try{
				$this->setTitle($title);
				$this->setDescription($descrip);
			} catch (Exception $e){
				throw new Exception("Tweakblog::__construct(): could not set attributes\n" . $e);				
			}
		}
		
		/**
		 * sets the title
		 * @author 	Thomas Pinna
		 * @param	a string that represents the title
		 */
		public function setTitle($arg){
			
			//PRECONDITIONs
			
			// check the input types
			if(!is_string($arg))
				{ throw new Exception("TweakBlog::setTitle() :Argument must be a string");}
			
			//LOGIC
			
			$this->title = $arg;
			
		}
		
		/**
		 * sets the description
		 * @author	Thomas Pinna
		 * @param	string: the description
		 */ 
		public function setDescription($arg){
			
			//PRECONDITIONs
			
			// check the input types
			if(!is_string($arg))
				{ throw new Exception("TweakBlog::setDescription() :Argument must be a string");}
			
			//LOGIC
			
			$this->descrip = $arg;
			
		}
		
		/**
		 * gets the title
		 * @author 	Thomas Pinna
		 * @return	string:	the title
		 */
		public function getTitle(){
			
			// LOGIC	
			
			//if we have the title, return it, else retrieve it
			if($this->title != ""){
				return $this->title;
			} else {
				// if we don't have it, retrieve it
				$htmlfile = new DOMDocument();
				@$htmlfile->loadHTMLFile($this->url);
				// find the appropriate node
				$h2elements = $htmlfile->getElementsByTagName("h2");
				$h2element  = $h2elements->item(0); 
				return $h2element->nodeValue;
			}
		}
		
		/**
		 * gets the author
		 * @author 	Thomas Pinna
		 * @return	string:	the author
		 */
		public function getAuthor(){ return $this->author; }
		
		/**
		 * gets the description
		 * @author 	Thomas Pinna
		 * @return 	string:	the description
		 */ 
		public function getDescription(){return $this->descrip;	}
		
		/**
		 * gets the contents of a file
		 * @author 	Thomas Pinna
		 * @return 	string:	The contents of the blog
		 */
		public function getBlog(){
				
			// LOGIC	
			
			// load the document			
			$htmlfile = new DOMDocument();
			@$htmlfile->loadHTMLFile($this->url);
			// find the appropriate node
			$xpath = new DOMXPath($htmlfile);
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
		 * @return 	array: a list of tweakblogreactions on this blog
		 */
		public function getReactions(){
			
			// LOGIC
			
			// load the document			
			$htmlfile = new DOMDocument();
			@$htmlfile->loadHTMLFile($this->url); 			
			// find the approptiate nodes
			$xpath = new DOMXPath($htmlfile);
			$nodes = $xpath->query("//*[@class='reactie']|//*[@class='reactie ownreply']");
			
			// here will we store the result
			$results = Array();
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
				$results[] = new TweakBlogReaction($usr, $msg);
			}
			
			return $results;
		}

		/**
		 * A function that returns a (basic) reaction form (doesn't work yet)
		 * @author 	Thomas Pinna
		 * @access 	public
		 * @return 	string: a form to a reaction
		 */
		public function getReactionForm(){
			
			// LOGIC
			
			/*// load the document			
			$htmlfile = new DOMDocument();
			@$htmlfile->loadHTMLFile($this->url); 			
			// find the approptiate nodes
			$xpath = new DOMXPath($htmlfile);
			$nodes = $xpath->query("//*[@id='reactieForm']");
			$node=$nodes->item(0);
			// extract html from the node, by creating new domdocument
			$newdoc = new DOMDocument();
		    $cloned = $node->cloneNode(TRUE);
		    $newdoc->appendChild($newdoc->importNode($cloned,TRUE));
		    // return results
		    return $newdoc->saveHTML();*/
		    
		    //TODO fix reactionform instead of just posting an url
		    return $this->url."#reacties";
		}

		/** 
		 * A function that gets a list of blogs written by a certain user
		 * @author 	Thomas Pinna
		 * @static
		 * @param 	string: url_name where url_name.tweakblogs.net leads to the homepage
		 * @return 	array: a list to urls to the different blogs of this user
		 */
		static public function getTweakblogsFrom( $url_name ){
			
			// PRECONDITIONS
			
			// check input types
			if(!is_string($url_name))
					{ throw new Exception("TweakBlog::getTweakblogsFrom(url_name) :Argument must be a string");}
			
			// LOGIC
			
			// create the url
			$url = "http://" . $url_name .".tweakblogs.net/feed/";
			//create the list of blogs and return them
			return TweakBlog::TweakBlogsFromRss($url);
		}
		
		/** 
		 * A function that gets a list of the most recent tweakblogs 
		 * @author 	Thomas Pinna
		 * @param 	BlackWhiteList: defines if a blog from a user should appear in the return result
		 * @return 	array: a list to urls to the different blogs of this user
		 */
		static public function getTweakblogsLatest($bwl = NULL ){
					
			// PRECONDITIONS
			
			if( !is_a($bwl, "TweakblogAPI\BlackWhiteList") && !is_null($bwl))
				{throw new Exception("TweakBlog::getTweakBlogLatest() :argument must be a BlackWhiteList or left empty");}
			
			// LOGIC
			
			//if not initiated, initiate the $bwl
			if( is_null($bwl)){
				$bwl = new BlackWhiteList(TRUE, array());
			}
			
			//create the url
			$url = "http://tweakblogs.net/feed/";
			//create the list of blogs
			$tweakblogs = TweakBlog::TweakBlogsFromRss($url);
			// filter the wrong ones out
			if( !is_null($bwl)){
				foreach ($tweakblogs as $key => $value) {
					if( !$bwl->isAllowed($value->getAuthor() ) ){
						unset($tweakblogs[$key]);
					}
				}
			}
			return $tweakblogs;
		}

		/**
		 * A helperfunction that converts a tweakers-rss link to an array of Tweakblogs
		 * @author	Thomas Pinna
		 * @param	String: The url to convert
		 * @return 	Array: a list of Tweakblogs
		 */
		static private function TweakBlogsFromRss($url){
			
			//PRECONDITION
			
			if(!is_string($url))
					{ throw new Exception("TweakBlog::getTweakblogsFromRss(url_name) :Argument must be a string"); }
			
			//LOGIC
				
			// load the url
			$xml=simplexml_load_file($url);
			$xml->addAttribute('encoding', 'UTF-8');
			// where to store the urls
			$result = array();
	
			//get the urls from the feed and create the Tweakblogs
			foreach ($xml->channel->children() as $value) {
				if (isset($value->guid)){
					$guid 		=	(string)($value->guid);
					$title		=	(string)($value->title);
					$descrip	=	(string)($value->description);
					$tweakblog 	= 	new TweakBlog($guid, $title, $descrip);
					$result[] 	= 	$tweakblog; 
				}
			}
			
			//return the result
			return $result;
		}
	}	
?>
