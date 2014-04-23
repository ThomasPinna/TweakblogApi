<head>
	<meta charset="UTF-8" />
</head>

<?php
    //require_once "TweakBlog.php";
    
	//get the tweakblogs
    
	try{
		$testcases = Array();
		
		// geen persoonlijk probleem met marcotm, maar hij is een mooi voorbeeld, aangezien hij heel frequent blogt
		$bw = new BlackWhiteList(TRUE, array("marcotm") );
		
		// get all the Tweakblogs from pinna
		$tb = TweakBlog::getTweakblogsFrom( "pinna" );
		// get all the latest Tweakblogs
		$tbl= TweakBlog::getTweakblogsLatest($bw);
		
		//last tweakblog from pinna
		$last_tb = $tb[0];
		
		
		echo "<pre>";
		print_r($tb);
		print_r($tbl);
		echo "</pre>";
		
		//the test tweakblog (for when things like title etcetera are not set by the getTweakblogsXXXX(function))
		$ttb = new Tweakblog("http://pinna.tweakblogs.net/blog/10130/update-tweakblog-api-01.html");
		
		//print title
		echo "<h1>";
		echo $ttb->getTitle();
		echo "</h1>";
		
		//print Description
		echo "<i>";
		echo $last_tb->getTime();
		echo " -- ";
		echo $ttb->getDescription();
		echo "</i>";
		
		//print contents
		echo $last_tb->getBlog();
		
		//print reactions
		$reactions = $last_tb->getReactions();
		foreach ($reactions as $reaction) {
			
			echo "<hr>";
			
			echo "<b>";
			echo $reaction->getName();
			echo "</b><br />";
			
			echo "<i>";
			echo $reaction->getMessage();
			echo "</i>";
			
		}
		
		//print reactionform
		echo $last_tb->getReactionForm();
	}catch(Exception $e){
		echo $e->getMessage();
	}
	
?>