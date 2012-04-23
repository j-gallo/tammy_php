<?php 
//start session to allow for 'logged-in' status
session_start();
//set default timezone to show proper 'created on' date in blogs
date_default_timezone_set('America/New_York');
?>

<!-- This code is the header layout for every page on the site -->

<!doctype html>  
<html lang="en">  
<head>  
<meta charset="utf-8">  
<title>Tammy Portnoy</title>  
<meta name="description" content="Tammy's Blog">  
<meta name="author" content="Julian">  
<link rel="stylesheet" media="screen" type="text/css" href="/stylesheets/main.css">  
      <!--[if lt IE 9]>  
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>  
      <![endif]-->
</head>

<!--display the links at the top of the page. If logged in, show admin-only links -->
<header>
  <nav>
   <ul>
     <li><a href='/tammy'>Home</a></li>
     <li><a href='/tammy/thoughts'>Thoughts</a></li>
     <li><a href='/tammy/portfolio'>Portfolio</a></li>
     <?php if(isset($_SESSION['logged_in'])){ ?>
     <li><a href='/tammy/blog'>Blog</a></li>
     <li><a href='/tammy/admin'>Admin</a></li>
     <li><a href='/tammy/admin?action=logout'>Signout</a></li>
     <?php } ?>
   </ul>
  </nav>
  <br />
  <br />
</header>
