<head>
	<meta charset="UTF-8" />
</head>

<?php
    require_once "TweakBlog.php";
    
	//get the tweakblogs
    
	try{
		$testcases = Array();
		
		// get all the Tweakblogs
		$tb = TweakblogAPI\TweakBlog::getTweakblogs( "pinna" );
		
		// the last tweakblog
		$last_tb = $tb[0];
		
		//print title
		echo "<h1>";
		echo $last_tb->getTitle();
		echo "</h1>";
		
		//print Description
		echo "<i>";
		echo $last_tb->getDescription();
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
	}catch(Exception $e){
		echo $e->getMessage();
	}
	
?>