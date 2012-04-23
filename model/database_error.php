<!-- this function catches and displays any errors that might 
     occur when connecting to the database. -->
<head>  
<meta charset="utf-8">  
<title>Klee Mock</title>  
<meta name="description" content="Tammy's Blog">  
<meta name="author" content="Julian">  
      <!--[if lt IE 9]>  
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>  
      <![endif]-->
</head>

<body>
  <h1>Database Error!</h1>
  <p>
    There was an error connecting to the database......
    <br />
    <br />
    <?php echo $e ?>
    <br />
    <br />
    Try again.
  </p>
</body>

<?php phpinfo() ?>
