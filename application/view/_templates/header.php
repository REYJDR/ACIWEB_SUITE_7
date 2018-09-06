<!DOCTYPE html>
<html lang="en">
<head>

<!-- Latest compiled and minified CSS -->
<script src="<?php echo URL; ?>js/otros/jquery-2.2.1.min.js" ></script>


<!-- Optional theme--> 
<link rel="stylesheet" href="<?php echo URL; ?>page_assets/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>page_assets/css/buttons.dataTables.min.css" >
<link rel="stylesheet" href="<?php echo URL; ?>page_assets/css/selectDatatables.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>page_assets/css/bootstrap-theme.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>page_assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo URL; ?>page_assets/css/rowReorder.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>page_assets/css/responsive.dataTables.min.css" rel="stylesheet">


<!-- NEW STYLE  --> 
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="page_assets/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="page_assets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="page_assets/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="page_assets/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="page_assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="page_assets/css/main.css">
<!--===============================================================================================-->


<!-- SELECT2 --> 
<link rel="stylesheet" href="<?php echo URL; ?>js/select2/select2.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>js/select2/select2-bootstrap.css" rel="stylesheet">

<!-- GRAPHS --> 
<!-- <link rel="stylesheet" href="<?php echo URL; ?>morris/morris.css" rel="stylesheet"> -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">


<!--  CUSTOM JS  --> 
<script src="<?php echo URL; ?>js/aplicacion/aciweb_script.js" ></script>


<!--  BOOTSTRAP JS  --> 
<script src="<?php echo URL; ?>js/otros/bootstrap.min.js" ></script>
<!--<script src="<?php echo URL; ?>dist/js/bootstrap-submenu.min.js" defer></script>-->


<!--  DATATABLES  JS --> 
<script  src="<?php echo URL; ?>js/otros/jquery.dataTables.min.js" ></script>
<script  src="<?php echo URL; ?>js/otros/selectDatatables.js" ></script>
<script  src="<?php echo URL; ?>js/otros/dataTables.buttons.min.js" ></script>
<script  src="<?php echo URL; ?>js/otros/buttons.flash.min.js" ></script>
<script  src="<?php echo URL; ?>js/otros/jszip.min.js" ></script>
<script  src="<?php echo URL; ?>js/otros/pdfmake.min.js" ></script>
<script  src="<?php echo URL; ?>js/otros/vfs_fonts.js" ></script>
<script  src="<?php echo URL; ?>js/otros/buttons.html5.min.js" ></script>
<script  src="<?php echo URL; ?>js/otros/buttons.print.min.js" ></script>
<script  src="<?php echo URL; ?>js/otros/buttons.colVis.min.js" ></script> 
<script  src="<?php echo URL; ?>js/otros/dataTables.colVis.js" ></script> 
<script  src="<?php echo URL; ?>js/otros/jquery.dataTables.columnFilter.js" ></script>
<script  src="<?php echo URL; ?>js/otros/jquery.dataTables.yadcf.js" ></script>
<script  src="<?php echo URL; ?>js/otros/dataTables.rowReorder.min.js" ></script>
<script  src="<?php echo URL; ?>js/otros/dataTables.responsive.min.js" ></script>
<script  src="<?php echo URL; ?>js/otros/sum().js"></script>

<!-- SELECT2  JS --> 
<script src="<?php echo URL; ?>js/select2/select2.min.js"></script>

<!--  GRAPHS  JS --> 
<!-- <script src="<?php echo URL; ?>morris/morris.js"></script> -->
<script src="<?php echo URL; ?>rgraph/libraries/RGraph.common.core.js" ></script>
<script src="<?php echo URL; ?>rgraph/libraries/RGraph.hbar.js" ></script>
<script src="<?php echo URL; ?>rgraph/libraries/RGraph.common.dynamic.js"></script>
<script src="<?php echo URL; ?>rgraph/libraries/RGraph.common.tooltips.js"></script>
<script src="<?php echo URL; ?>rgraph/libraries/RGraph.common.key.js"></script>
<script src="<?php echo URL; ?>rgraph/libraries/RGraph.pie.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>



<meta name="viewport" content="width=device-width, initial-scale=1">
</head> 
<body>
<div class="loader"></div>
<div id="allDocument">
    
<?php 
      header('Content-Type: text/html; charset=utf-8'); 
	  define(VER,'V_6.9.18_4');
	  ?>
<input type="hidden" id="active_user_id" value="<?php echo $this->model->active_user_id; ?>" />
<input type="hidden" id='URL' value="<?php ECHO URL; ?>" />
