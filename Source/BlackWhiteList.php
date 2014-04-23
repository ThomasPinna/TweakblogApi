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
	 * A class that defines a Black or a white list
	 * @author	Thomas Pinna
	 */
	class BlackWhiteList {
		
		/// A bool to store if it is a black or a white list
		private $isBlackList;
		///	An array that contains the values in the Black/Whitelist
		private	$valueList;
		
		/**
		 * Constructor for the BlackWhiteList
		 * @author	Thomas Pinna
		 * @param	bool:	if true, it'll be a blacklist, otherwise a whitelist
		 * @param	array:	the list of values that are (not) allowed, depending on Black or whitelist
		 */
		public function __construct($isBlackList, $list = array() ) {
			
			// PRECONDITIONS
			
			// check the input types
			if(!is_bool($isBlackList))
				{ throw new \Exception("BlackWhiteList::__construct() first argument must be a boolean");}
			if(!is_array($list))
				{ throw new \Exception("BlackWhiteList::__construct() second argument must be an array");}
				
			// LOGIC
			
			$this->isBlackList = $isBlackList;
			$this->valueList = $list;
		}
		
		/**
		 * function to add an element from the Black or white list
		 * @author	Thomas Pinna
		 * @param	element:	The element of any type to be added
		 */
		public function add($elem){
			
			// LOGIC
			
			if( ! in_array($elem, $this->valueList, TRUE)){
				$this->valueList[] = $elem;
			}
		}
		
		/**
		 * function to remove an element from the Black or white list
		 * @author	Thomas Pinna
		 * @param	element:	The element of any type to be removed
		 */
		public function remove($elem){
			
			// PRECONDITION
			
			if( ! in_array($elem, $this->valueList, TRUE) )
				{ throw new \Exception("BlackWhiteList::remove() :can't remove an element that doesn't exist"); }
				
			// LOGIC
			
			$key = array_search($elem, $this->valueList, TRUE);
			unset($this->valueList[$key]);
		}
		
		/**
		 * function to check if a certain value is allowed by the Black/WhiteList
		 * @author	Thomas Pinna
		 * @param	element:	The element to allow or deny
		 * @return	bool:		true if it is allowed, false if it isn't
		 */
		public function isAllowed($elem){
			
			//LOGIC
			
			// if in array then it must be a whitelist to be true, if not in array it must be a blacklist to be true
			return ( in_array($elem, $this->valueList, TRUE) ) ? !$this->isBlackList : $this->isBlackList ;
		}
		
		/**
		 * function to filter out results that or not allowed
		 * @author	Thomas Pinna
		 * @param	An array with values to be filtered out
		 */
		public function filter($array){
			
			//PRECONDITION
			
			if(!is_array($array))
				{throw new Exception("BlackWhiteList::filter() : can only have an array as parameter");}
				
			//LOGIC
			
			//optimalisation for when empty Blacklist - everything is allowed
			if (!$this->isBlackList && empty($this->valueList) ){
				return;
			}
			
			//loop over the array and check each value 
			foreach ($array as $key => $value) {
				if( !$this->isAllowed($value) ){
					unset($array[$key]);
				}
			}
			
		}
	}
?>