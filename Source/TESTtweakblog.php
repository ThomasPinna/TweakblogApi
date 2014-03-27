<?php
    require_once "tweakblog.php"
?>
			<head>
				<meta charset="UTF-8" />
			</head>
			<h1>Pinna Tweakblog testcase</h1>
			
			<h2>Get a list of Tweakblog objects</h2>
			
			<h3><code>	$tb = TweakBlog::getTweakblogs( "pinna" );
						print_r( $tb ); </code></h3><br>
			<pre><?php 
						$tb = TweakBlog::getTweakblogs( "pinna" );
						print_r( $tb ); 
			?></pre><br>
			
			<h2>Get the contents of a Tweakblog</h2>
			
			<h3><code>echo $tb[0]->getTitle(); </code></h3><br>
			<?php 
					echo $tb[0]->getTitle(); 
			?><br>
			
			<h3><code>echo $tb[0]->getDescription(); </code></h3><br>
			<?php 
					echo $tb[0]->getDescription();
			?><br>
			
			<h3><code>echo substr($tb[0]->getBlog(), 0, 1000)."..."; </code></h3><br>
			<?php 
					echo mb_substr($tb[0]->getBlog(), 0, 1000)."...";
			?><br>
			
			<h3><code>print_r($tb[0]->getReactions()[0]); </code></h3><br>
			<?php 
					print_r($tb[0]->getReactions()[0]);
			?><br>

