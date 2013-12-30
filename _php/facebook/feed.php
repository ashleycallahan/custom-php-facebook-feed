<?php

	// ================= EDIT THE VARIABLES BELOW ===================== //
	
	// Facebook username
	$facebookuser = "IndianaUniversity";
		
	// Number of posts to display
	$noposts = 15;

	// Length of time between renewing the cache file in seconds (2 hours in this case)
	$cachetime = 7200; 
	
	// Server path to parent folder
	$cachepath = "/hermes/bosoraweb162/b1007/ipw.arc2/public_html/custom-php-facebook-feed/_php/facebook/cache.txt";
	
	// CREATE A FACEBOOK APPLICATION TO GET THE FOLLOWING VARIABLES (https://developers.facebook.com/apps)
	
	  // OAtuh settings - Client ID
	  $client_id = "170051759721437";
	  
	  // OAuth settings = Client Secret
	  $client_secret = "dce26c83db4c07e1c59caefe9edbbe75";
	
	// Default timezone (Reference: http://www.php.net/manual/en/timezones.php)
	$timezone = "America/Indiana/Indianapolis";
	
	// Date format (Reference: http://php.net/manual/en/function.date.php) 
	$dateformat = "l, F, j, g:ia";
	
	
	// ================= STOP EDITING! ===================== //
	
    if(file_exists($cachepath) && time() < filemtime($cachepath) + $cachetime){
		$json = file_get_contents($cachepath,0,null,null);
		$json_output = json_decode($json, true);
	}
	else {
		$access_token = file_get_contents("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=".$client_id."&client_secret=".$client_secret);
		$jsonurl = "https://graph.facebook.com/".$facebookuser."/posts?limit=".$noposts."&".$access_token;
		$json = file_get_contents($jsonurl,0,null,null);
		$json_output = json_decode($json, true);
		for($i=0; $i<$noposts; $i++){
			$jsonurl_likes = "https://graph.facebook.com/".$json_output[data][$i][object_id]."/likes?summary=1";
			$json_likes = file_get_contents($jsonurl_likes,0,null,null);
			if($i==0){
				$likes .= $json_likes;
			} else {
				$likes .= ", ".$json_likes;
			}
		}
		$json_combined = '{"posts":['.$json.'], "likes":['.$likes.']}';
		$json_output = json_decode($json_combined, true);
		$fp = fopen($cachepath, 'w');
		fwrite($fp, $json_combined);
		fclose($fp);
	}
	$posts = $json_output;
	echo "<ul class='facebook-custom-feed'>";
	for($i=0; $i<$noposts; $i++){
		echo "<li><p>";
		echo "<a href='https://www.facebook.com/".$facebookuser."' target='_blank' class='facebook-custom-feed-account'>".$posts[posts][0][data][$i][from][name]."</a><br />";
		date_default_timezone_set($timezone);
		echo "<span class='facebook-custom-feed-date'>".date($dateformat,strtotime($posts[posts][0][data][$i][created_time]))."</span><br />";
		if($posts[posts][0][data][$i][message]){
			$post_message = "";
			$post_message = $posts[posts][0][data][$i][message];
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
		if($posts[posts][0][data][$i][picture]){
			echo "<p class='facebook-custom-feed-photo'>";
			if($posts[posts][0][data][$i][link]){
				echo "<a href='".$posts[posts][0][data][$i][link]."' target='_blank'>";
			}
			echo "<img src='".$posts[posts][0][data][$i][picture]."' class='facebook-custom-feed-photo'/>";
			if($posts[posts][0][data][$i][link]){
				echo "</a>";
			}
			if($posts[posts][0][data][$i][link] && $posts[posts][0][data][$i][name]){
				echo "<a href='".$posts[posts][0][data][$i][link]."' target='_blank' class='facebook-custom-feed-photo-link'>".$posts[posts][0][data][$i][name]."</a><br />";
			}
			if($posts[posts][0][data][$i][caption]){
				echo "<span class='facebook-custom-feed-photo-caption'>".$posts[posts][0][data][$i][caption]."</span><br />";
			}
			if($posts[posts][0][data][$i][description]){
				echo "<span class='facebook-custom-feed-photo-description'>".$posts[posts][0][data][$i][description]."</span>";
			}
			echo "</p>";
		}
		echo "<p class='facebook-custom-feed-likes'><span class='facebook-custom-feed-likes'>".$posts[likes][$i][summary][total_count]." people like this</span>";
		echo " &#149; <a href='".$posts[posts][0][data][$i][link]."' target='_blank' class='facebook-custom-feed-like'>Like</a>";
		echo " &#149; <a href='http://www.facebook.com/sharer/sharer.php?u=".$posts[posts][0][data][$i][link]."' target='_blank' class='facebook-custom-feed-share'>Share</a>";
		echo "</p></li>";
	}
	echo "</ul>";
	
?>