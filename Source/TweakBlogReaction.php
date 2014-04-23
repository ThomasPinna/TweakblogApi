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
	
	//namespace TweakblogAPI;
	
	/**
	 * A class that represents a reaction on a tweakblog
	 * @author	Thomas Pinna
	 */
	class TweakBlogReaction {
		
		///string: The name of the user who posted it
		private $usr;
		///string: The contents of the message
		private $msg;
		
		/**
		 * Constructs a reaction object from a username and a message
		 * @author	Thomas Pinna
		 * @access 	public
		 * @param	string: username
		 * @param	string:	message
		 */
		public function __construct($username, $message) {
			
			// PRECONDITION
			
			// check the input types
			if ( !is_string($username)) 
					{ throw new Exception("TweakBlogReaction::__construct: first argument must be a string");}
			if ( !is_string($message)) 
					{ throw new Exception("TweakBlogReaction::__construct: second argument must be a string");}
					
			// LOGIC
			
			// set local data
			$this->usr 	= $username;
			$this->msg	= $message;
		}
		
		/**
		 * @author	Thomas Pinna
		 * @access	public
		 * @return 	string: username
		 */
		public function getName(){
			return $this->usr;
		}
		
		/**
		 * @author	Thomas Pinna
		 * @access	public
		 * @return	string: message
		 */
		public function getMessage(){
			return $this->msg;
		}
	}
	 

?>