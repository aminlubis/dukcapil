<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Error</title>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
    
     <?php 
    if(ENVIRONMENT=='production') {
         echo '<script>window.location.assign("'.base_url().'")</script>';
         echo '<script>parent.document.location.href = "'.base_url().'";</script>';
    }
    /*else {
        echo '<script> alert("Heading : '.$heading.' message : '.$message.'")</script>';
    }*/
 ?>
</body>
</html>