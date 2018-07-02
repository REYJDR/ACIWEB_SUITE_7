<?php 

  if(isset($_POST['submit']))
  {
      //inicio variables de session
      $user = $_POST['Username'];
      $pass = md5($_POST['Password']);

      $login = $this->model->login_in($user,$pass); 
  }


  if(isset($this->model->active_user_id)){

  
  $res = $this->model->Query('SELECT * FROM SAX_USER  where SAX_USER.onoff="1" and SAX_USER.id="'.$this->model->active_user_id.'";');
   
  foreach ($res as $value) {
  
    $value = json_decode($value);
  
    $id = $value->{'id'};
    $name = $value->{'name'};
    $lastname = $value->{'lastname'};
    $email = $value->{'email'};
    $pass = $value->{'pass'};
    $role= $value->{'role'};
    $INF_OC= $value->{'notif_oc'};
    $INF_FC= $value->{'notif_fc'};
    $INF_PRICE= $value->{'mod_price'};
    $INF_INV= $value->{'inv_view'};
    $INF_STO= $value->{'stoc_view'};
    $INF_REP= $value->{'rep_view'};
    $PHOTO  = $value->{'photo'};
    $INF_rol_1= $value->{'role_purc'};
    $INF_rol_2= $value->{'role_fiel'};
    $CLO_SO   = $value->{'closeSO'};
    $AMNT_SO  =  $value->{'amountSO'};
    $PRINTER = $this->getPrinterById($value->{'printer'});
  
    $prnterID = $value->{'printer'};
     
      if( $PRINTER == ''){
  
      $PRINTER = 'Ninguna';
      $prnterID = null;
      }
  
      if($PHOTO == 'x'){
        $user_avatar = URL.'img/user_avatar/'.$id.'.jpg';
      }else{
        $user_avatar = URL.'img/default-avatar.png';
      }
  
      if($INF_OC==1){//notificaciones requisiciones
        $notif_oc = 'checked';
      }else{
        $notif_oc = ''; 
      }
  
      if($INF_FC==1){//notificaciones acturas
        $notif_fc = 'checked';
      }else{
        $notif_fc = ''; 
      }
  
      if($INF_PRICE==1){//modificar precio
        $price_mod = 'checked';
      }else{
        $price_mod = '';  
      }
  
      if($INF_INV==1){//ver inventario
       $INV_CK = 'checked';
      }else{
       $INV_CK = ''; 
      }
  
      if($INF_STO==1){//ver inventario
       $STO_CK = 'checked';
      }else{
       $STO_CK = ''; 
      }

      if($INF_REP==1){//ver inventario
        $REP_CK = 'checked';
      }else{
        $REP_CK = ''; 
      }
  
      if($CLO_SO==1){//cerrar ordenes
        $closeSO = 'checked';
      }else{
        $closeSO = ''; 
      }
  
      if($AMNT_SO==1){//ver montos ordenes    
        $amountSO = 'checked';
      }else{
        $amountSO = ''; 
      }
  
      if($INF_rol_1==1){//notificaciones
          $rol_purc_value = 'checked';
      }else{
         $rol_purc_value= '';	
      }
  
      if($INF_rol_2==1){//notificaciones
          $rol_field_value = 'checked';
      }else{
          $rol_field_value = '';	
      }
  
  }
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="#0be0af">
<meta name="apple-mobile-web-app-title" content="ACIWEB">


<link rel="manifest" href="<?php echo URL; ?>assets/manifest.json">
<link rel="apple-touch-icon" href="<?php echo URL; ?>assets/images/apcon_icono.png" />
<link href="<?php echo URL; ?>assets/images/apple-touch-startup-image-320x460.png" media="(device-width: 320px)" rel="apple-touch-startup-image">
<link href="<?php echo URL; ?>assets/images/apple-touch-startup-image-640x920.png" media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">   
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/framework7.css">
<link rel="stylesheet" href="<?php echo URL; ?>assets/style.css">
<link rel="stylesheet" href="<?php echo URL; ?>assets/css/custom.css">
<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="<?php echo URL; ?>assets/css/swipebox.css" />
<link type="text/css" rel="stylesheet" href="<?php echo URL; ?>assets/css/animations.css" />

<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,900" rel="stylesheet"> 

<!-- SELECT2 --> 
<link rel="stylesheet" href="<?php echo URL; ?>js/select2/select2.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo URL; ?>js/select2/select2-bootstrap.css" rel="stylesheet">


<!-- GENERAL JS -->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/jquery.validate.min.js" ></script>


<!-- SELECT2  JS --> 
<script src="<?php echo URL; ?>js/select2/select2.min.js"></script>

<!-- CUSTOM  JS --> 
<script type="text/javascript" src="<?php echo URL; ?>assets/js/custom.js"></script>


</head>
<body id="mobile_wrap">
<!-- <div class="info_popup">
	<div class="close_info_popup"><img src="<?php echo URL; ?>assets/images/icons/white/menu_close.png" alt="" title="" /></div>
	<h2>Save this WEB APP</h2>
	<h3>on your mobile</h3>
	<i>Next time you enter load it directly from your mobile home screen</i>
	<p><span>iOS</span>: Tap the Share button on the menu bar. It’s an icon on the right side that’s a box with an arrow sticking out from it. Tap on Add to Home Screen.</p>
	<p><span>Android</span>: Tap the browser menu button and tap Add to homescreen</p>
    </div> -->
    

<input type="hidden" id='URL' value="<?php ECHO URL; ?>" />
<input type="hidden" id="active_user_id" value="<?php echo $this->model->active_user_id; ?>" />

    <div class="statusbar-overlay"></div>

    <div class="panel-overlay"></div>

    <div class="panel panel-left panel-reveal">
	<div class="view view-subnav">
	<div class="pages">
		<div data-page="panel-leftmenu" class="page pagepanel">	

         <div class="page-content">
         
			<nav class="main_nav_icons_inline_2">
			<ul>
            <li><a href="#" data-popup=".popup-login" class="open-popup close-panel"><img src="<?php echo URL; ?>assets/images/icons/white/lock.png" alt="" title="" /><span>Login</span></a></li>
            <li><a href="form.html" class="close-panel" data-view=".view-main"><img src="<?php echo URL; ?>assets/images/icons/white/form.png" alt="" title="" /><span>Sales Order</span></a></li>
            <li><a href="team.html" class="close-panel" data-view=".view-main"><img src="<?php echo URL; ?>assets/images/icons/green/search.png" alt="" title="" /><span>Search</span></a></li>

			<!--<li><a href="index.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Home</span></a></li>
			<li><a href="about.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>About</span></a></li>
			<li><a href="features.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Features</span></a></li>		
			<li><a href="team.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Team</span></a></li>
			<li><a href="blog.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Blog</span></a></li>		
      <li><a href="photos.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Photos</span></a></li>
			<li><a href="videos.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Videos</span></a></li>
			<li><a href="music.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Music</span></a></li>	
			<li><a href="shop.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Shop</span></a></li>
			<li class="subnav"><a href="categories.html"><img src="" alt="" title="" /><span>Sub level menu</span></a></li>
			<li><a href="cart.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Cart</span></a></li>
			<li><a href="tables.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Tables</span></a></li>
			<li><a href="chat.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Chat messages</span></a></li>
			<li><a href="contact.html" class="close-panel" data-view=".view-main"><img src="" alt="" title="" /><span>Contact</span></a></li>-->  
			</ul>
			</nav>
     
           </div>
		</div>
	  </div>
	</div>  
    </div>

    <div class="panel panel-right panel-reveal">
      <div class="user_login_info">
	  
                <div class="user_thumb">
                <img  src="<?php echo URL; ?>assets/images/user/logo_aci.png" alt="" title="" />
                  <div class="user_details">

                        <p>Bienvenido, <span><?php echo $this->model->active_user_name.' '.$this->model->active_user_lastname; ?></span></p>

                  </div>  
                  <div class="user_avatar"><img src="<?php echo $user_avatar; ?>" alt="" title="" /></div>       
                </div>
				
                  <nav class="user-nav">
                    <ul>
                    <!--<li><a href="features.html" class="close-panel"><img src="images/icons/white/settings.png" alt="" title="" /><span>Account Settings</span></a></li> -->
                      <li><a href="<?php echo URL; ?>index.php?url=home/mob_account/<?php echo $this->model->active_user_id; ?>" class="close-panel"><img src="<?php echo URL; ?>assets/images/icons/white/briefcase.png" alt="" title="" /><span>Perfil</span></a></li>
                    <!--<li><a href="features.html" class="close-panel"><img src="images/icons/white/message.png" alt="" title="" /><span>Messages</span><strong>12</strong></a></li>
                      <li><a href="features.html" class="close-panel"><img src="images/icons/white/love.png" alt="" title="" /><span>Favorites</span><strong>5</strong></a></li>-->
                      <li><a  onclick='javascript: logout(<?php echo '"'.URL.'"'; ?>);' href="#" class="close-panel"><img src="<?php echo URL; ?>assets/images/icons/white/lock.png" alt="" title="" /><span>Salir</span></a></li>
                    </ul>
                  </nav>
      </div>
    </div>

    <div class="views">

      <div class="view view-main">

        <div class="pages">

          <div data-page="index" class="page homepage">
            <div class="page-content">
			
                        <div class="navbarpages">
                            <div class="navbar_left">
                                <div class="logo_text"><a href="index.html"><img width="30" height="30" src="<?php echo URL; ?>assets/images/apcon_icon.ico" /></a></div>
                            </div>
              
        <?php if($this->model->verify_session() == '0'){ ?>
        <!-- <div class="navbar_right navbar_right_menu">
				<a href="#" data-panel="left" class="open-panel"><img src="<?php echo URL; ?>assets/images/icons/white/menu.png" alt="" title="" /></a>
			    </div>	-->		
			    <div class="navbar_right">
				<a href="#" data-panel="right" class="open-panel"><img src="<?php echo URL; ?>assets/images/icons/white/user.png" alt="" title="" /></a>
			    </div>
              <?php } ?>
			  <!--  <div class="navbar_right">
				<a href="cart.html" data-view=".view-main"><img src="images/icons/white/cart.png" alt="" title="" /><span>3</span></a>
			    </div> -->
                        </div>

             <!-- Slider -->
             <div class="swiper-container slidertoolbar swiper-init" data-effect="slide" data-parallax="true" data-pagination=".swiper-pagination"  data-next-button=".swiper-button-next" data-prev-button=".swiper-button-prev">
                    <div class="swiper-wrapper">
                    
                        <!--each slide -->

                      <?php 
                          $dir    = 'assets/images/slider/';;
                          $images = scandir($dir);

          
                          foreach($images as $slide){

                            list($name,$ext) = explode('.',$slide);

            
                            if($ext == 'jpg'){

                            echo '<div class="swiper-slide" style="background-image:url(assets/images/slider/'.$slide.');">
                            <div class="slider_trans">
                            <div class="slider-caption">
                     <!--   <span class="subtitle" data-swiper-parallax="-60%">'.$name.'</span> -->
                            <h2 data-swiper-parallax="-100%"></h2>      
                            <p data-swiper-parallax="-30%"></p>
                            </div>
                            </div> </div>';

                            } 

                            }
                      ?>
                      <!--end each slide -->
	   
                    </div>
                  <div class="swiper-pagination"></div>
                  <div class="swiper-button-prev"></div>
                  <div class="swiper-button-next"></div>	
           </div>
		     	<!--Fin  Slider -->


		 <div class="swiper-container-toolbar swiper-toolbar swiper-init" data-effect="slide" data-slides-per-view="1" data-slides-per-group="1" data-space-between="0" data-pagination=".swiper-pagination-toolbar">
			<div class="swiper-pagination-toolbar"></div>
			<div class="swiper-wrapper">
			  <div class="swiper-slide toolbar-icon">
              <?php if($this->model->verify_session() != '0'){ ?>

                <a href="#" data-popup=".popup-login" class="open-popup"><img src="<?php echo URL; ?>assets/images/icons/green/lock.png" alt="" title="" /><span>LOGIN</span></a>
                
              <?php }else{ ?>

                <a href="<?php echo URL; ?>index.php?url=ges_ventas/mob_orden_ventas" data-view=".view-main"><img src="<?php echo URL; ?>assets/images/icons/green/form.png" alt="" title="" /><span>Pedidos</span></a>
                <a href="<?php echo URL; ?>index.php?url=ges_reportes/rep_so" data-view=".view-main"><img src="<?php echo URL; ?>assets/images/icons/green/search.png" alt="" title="" /><span>Historial</span></a>
                
              <?php } ?>
               
             <!--<a href="blog.html" data-view=".view-main"><img src="images/icons/green/blog.png" alt="" title="" /><span>JOURNAL</span></a>
                    <a href="photos.html" data-view=".view-main"><img src="images/icons/green/photos.png" alt="" title="" /><span>PHOTOS</span></a>
                    <a href="contact.html" data-view=".view-main"><img src="images/icons/green/contact.png" alt="" title="" /><span>CONTACT</span></a>-->
                </div> 
			 <!-- <div class="swiper-slide toolbar-icon">
                  <a href="features.html" data-view=".view-main"><img src="images/icons/green/features.png" alt="" title="" /><span>FEATURES</span></a>
				  <a href="shop.html" data-view=".view-main"><img src="images/icons/green/shop.png" alt="" title="" /><span>SHOP</span></a>
				  <a href="music.html" data-view=".view-main"><img src="images/icons/green/music.png" alt="" title="" /><span>MUSIC</span></a>
				  <a href="#" data-popup=".popup-social" class="open-popup"><img src="images/icons/green/twitter.png" alt="" title="" /><span>SOCIAL</span></a>
				  <a href="videos.html" data-view=".view-main"><img src="images/icons/green/video.png" alt="" title="" /><span>VIDEOS</span></a>
				  <a href="tel:12345678" class="external"><img src="images/icons/green/phone.png" alt="" title="" /><span>CALL NOW!</span></a>
			   </div>-->

			</div>
		  </div>	

			  
            </div>
          </div>
        </div>



      </div>
    </div>


    <!-- Login Popup -->
    <div class="popup popup-login">
        <div class="content-block">
            <h4>LOGIN</h4>
            <div class="loginform">
                <form id="LoginForm" method="post">
                    <input type="text" name="Username" value="" class="form_input required" placeholder="username" />
                    <input type="password" name="Password" value="" class="form_input required" placeholder="password" />
               <!--     <div class="forgot_pass"><a href="#" data-popup=".popup-forgot" class="open-popup">Forgot Password?</a></div><! -->
                    <input type="submit" name="submit" class="form_submit" id="submit" value="Entrar" />
                </form>
               <!-- <div class="signup_bottom">
                    <p>Don't have an account?</p>
                    <a href="#" data-popup=".popup-signup" class="open-popup">SIGN UP</a>
                </div>-->
            </div>
            <div class="close_popup_button">
                <a href="#" class="close-popup"><img src="<?php echo URL; ?>assets/images/icons/black/menu_close.png" alt="" title="" /></a>
            </div>
        </div>
    </div>

    <!-- Register Popup -->
    <!--<div class="popup popup-signup">
        <div class="content-block">
            <h4>REGISTER</h4>
            <div class="loginform">
                <form id="RegisterForm" method="post">
                    <input type="text" name="Username" value="" class="form_input required" placeholder="Username" />
                    <input type="text" name="Email" value="" class="form_input required" placeholder="Email" />
                    <input type="password" name="Password" value="" class="form_input required" placeholder="Password" />
                    <input type="submit" name="submit" class="form_submit" id="submit" value="SIGN UP" />
                </form>
		<h5>- OR REGISTER WITH A SOCIAL ACCOUNT -</h5>
		<div class="signup_social">
			<a href="http://www.facebook.com/" class="signup_facebook external">FACEBOOK</a>
			<a href="http://www.twitter.com/" class="signup_twitter external">TWITTER</a>            
		</div>		
            </div>
            <div class="close_popup_button">
                <a href="#" class="close-popup"><img src="assets/images/icons/black/menu_close.png" alt="" title="" /></a>
            </div>
        </div>
    </div>-->
	
    <!-- Forgot Password Popup -->
    <!-- <div class="popup popup-forgot">
        <div class="content-block">
            <h4>FORGOT PASSWORD</h4>
            <div class="loginform">
                <form id="ForgotForm" method="post">
                    <input type="text" name="Email" value="" class="form_input required" placeholder="email" />
                    <input type="submit" name="submit" class="form_submit" id="submit" value="RESEND PASSWORD" />
                </form>
                <div class="signup_bottom">
                    <p>Check your email and follow the instructions to reset your password.</p>
                </div>
            </div>
            <div class="close_popup_button">
                <a href="#" class="close-popup"><img src="assets/images/icons/black/menu_close.png" alt="" title="" /></a>
            </div>
        </div>
    </div>-->
	
    <!-- Social Icons Popup -->
    <!-- <div class="popup popup-social">
    <div class="content-block">
      <h4>Social Share</h4>
      <p>Share icons solution that allows you share and increase your social popularity.</p>
      <ul class="social_share">
      <li><a href="http://twitter.com/" class="external"><img src="assets/images/icons/black/twitter.png" alt="" title="" /><span>TWITTER</span></a></li>
      <li><a href="http://www.facebook.com/" class="external"><img src="assets/images/icons/black/facebook.png" alt="" title="" /><span>FACEBOOK</span></a></li>
      <li><a href="http://plus.google.com" class="external"><img src="assets/images/icons/black/gplus.png" alt="" title="" /><span>GOOGLE</span></a></li>
      <li><a href="http://www.dribbble.com/" class="external"><img src="assets/images/icons/black/dribbble.png" alt="" title="" /><span>DRIBBBLE</span></a></li>
      <li><a href="http://www.linkedin.com/" class="external"><img src="assets/images/icons/black/linkedin.png" alt="" title="" /><span>LINKEDIN</span></a></li>
      <li><a href="http://www.pinterest.com/" class="external"><img src="assets/images/icons/black/pinterest.png" alt="" title="" /><span>PINTEREST</span></a></li>
      </ul>
      <div class="close_popup_button"><a href="#" class="close-popup"><img src="images/icons/black/menu_close.png" alt="" title="" /></a></div>
    </div>
    </div>-->
    
<!-- GENERAL JS -->
<script type="text/javascript" src="<?php echo URL; ?>assets/js/framework7.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/jquery.swipebox.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/jquery.fitvids.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/email.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/audio.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>assets/js/my-app.js"></script>


  </body>
</html>