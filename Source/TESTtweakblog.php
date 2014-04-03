<head>
	<meta charset="UTF-8" />
</head>

<?php
    require_once "TweakBlog.php";
    
	//get the tweakblogs
    
	try{
		$testcases = Array();
		
		// get all the Tweakblogs from pinna
		$tb = TweakblogAPI\TweakBlog::getTweakblogsFrom( "pinna" );
		// get all the latest Tweakblogs
		$tbl= TweakblogAPI\TweakBlog::getTweakblogsLatest();
		
		// the last tweakblog
		$last_tb = $tb[0];
		
		echo "<pre>";
		print_r($tbl);
		echo "</pre>";
		
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
		
		//print reactionform
		echo $last_tb->getReactionForm();
	}catch(Exception $e){
		echo $e->getMessage();
	}
	
?>