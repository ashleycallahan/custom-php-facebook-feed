<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Custom Facebook Feed</title>
<style>
	.facebook-custom-feed {
		list-style: none;
		margin: 0;
		padding: 0;
		width: 50%;	
	}
	.facebook-custom-feed li {
		border-bottom: 1px solid #ccc;
		margin: 0 0 10px 0;
		padding: 0 0 10px 0;	
	}
	.facebook-custom-feed li:last-child {
		border-bottom: none;
		margin-bottom: 0;
		padding-bottom: 0;
	}	
	.facebook-custom-feed li p {
		margin: 0 0 5px 0;
		padding: 0;	
	}
	.facebook-custom-feed li span {
		display: block;	
	}
	.facebook-custom-feed li a {
		color: #990000;
		text-decoration: none;
	}	
	.facebook-custom-feed .facebook-custom-feed-photo {
		overflow: hidden;	
	}
	.facebook-custom-feed img.facebook-custom-feed-photo {
		float: left;
		margin: 5px 10px 10px 0;	
	}
	.facebook-custom-feed .facebook-custom-feed-likes span {
		display: inline;	
	}
</style>
</head>
<body>
	<h1>Custom PHP Facebook Feed</h1>
	<?php include("_php/facebook/feed.php"); ?>
</body>
</html>