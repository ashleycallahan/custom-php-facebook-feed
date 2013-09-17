<?php

	// ================= EDIT THE VARIABLES BELOW ===================== //
	
	// Twitter username
	$facebookuser = "IndianaUniversity";
		
	// Number of Tweets to display
	$noposts = 15;

	// Length of time between renewing the cache file in seconds (2 hours in this case)
	$cachetime = 10; 
	
	// Server path to parent folder
	$cachepath = "/ip/iuwebdev/www/arc2/social-media/facebook/_php/facebook/";
	
	// CREATE A FACEBOOK APPLICATION TO GET THE FOLLOWING VARIABLES (https://developers.facebook.com/apps)
	
	  // OAtuh settings - Client ID
	  $client_id = "170051759721437";
	  
	  // OAuth settings = Client Secret
	  $client_secret = "dce26c83db4c07e1c59caefe9edbbe75";
	

	// ================= STOP EDITING! ===================== //
	
	$cachefile = "cache.txt";
    if(file_exists($cachefile) && time() < filemtime($cachefile) + $cachetime){
		$json = file_get_contents($cachefile,0,null,null);
		$json_output = json_decode($json, true);
	}
	else {
		$access_token = file_get_contents("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=".$client_id."&client_secret=".$client_secret);
		$jsonurl = "https://graph.facebook.com/".$facebookuser."/posts?limit=".$noposts."&".$access_token;
		$json = file_get_contents($jsonurl,0,null,null);
		$json_output = json_decode($json, true);
		$fp = fopen($cachepath.$cachefile, 'w');
		fwrite($fp, $json);
		fclose($fp);
	}
	$posts = $json_output;
	echo "<ul class='facebook-custom-feed'>";
	for($i=0; $i<$noposts; $i++){
		echo "<li><p>";
		echo "<a href='https://www.facebook.com/".$posts['data'][$i][from][name]."' target='_blank' class='facebook-custom-feed-account'>".$posts['data'][$i][from][name]."</a>";
		echo "<span class='facebook-custom-feed-date'>".date("l, F, j, g:ia",strtotime($posts['data'][$i][created_time]))."</span>";
		if($posts['data'][$i][message]){
			$post_message = "";
			$post_message = $posts['data'][$i][message];
			$post_message_words = "";
			$post_message_words = explode(" ",$post_message);
			$post_message_word_clean = "";
			foreach($post_message_words as $post_message_word){
				if(strstr($post_message_word,"http:")){
					$post_message_word = "<a href='".$post_message_word."' target='_blank'>".$post_message_word."</a>";
				}
				$post_message_word_clean .= $post_message_word." ";
			}
			echo "<span class='facebook-custom-feed-message'>".$post_message_word_clean."</span></p>";
		}
		if($posts['data'][$i][picture]){
			echo "<p class='facebook-custom-feed-photo'>";
			if($posts['data'][$i][link]){
				echo "<a href='".$posts['data'][$i][link]."' target='_blank'>";
			}
			echo "<img src='".$posts['data'][$i][picture]."' class='facebook-custom-feed-photo'/>";
			if($posts['data'][$i][link]){
				echo "</a>";
			}
			if($posts['data'][$i][link] && $posts['data'][$i][name]){
				echo "<a href='".$posts['data'][$i][link]."' target='_blank' class='facebook-custom-feed-photo-link'>".$posts['data'][$i][name]."</a>";
			}
			if($posts['data'][$i][caption]){
				echo "<span class='facebook-custom-feed-photo-caption'>".$posts['data'][$i][caption]."</span>";
			}
			if($posts['data'][$i][description]){
				echo "<span class='facebook-custom-feed-photo-description'>".$posts['data'][$i][description]."</span>";
			}
			echo "</p>";
		}
		echo "<p class='facebook-custom-feed-likes'><span class='facebook-custom-feed-liked'>".$posts['data'][$i][likes][count]." people like this</span>";
		echo " • <a href='https://www.facebook.com/".$posts['data'][$i][id]."' target='_blank' class='facebook-custom-feed-like'>Like</a>";
		echo "</p></li>";
	}
	echo "</ul>";
	
?>