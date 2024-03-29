<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class db_config  extends Controller
{

    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the dsefault page btw)
     */
  
    public function index($msg)
    {
        if($msg==''){
           
            $this->model->verify_session();
            $user_role =  $this->model->active_user_role;

        }else{

            $user_role = 'admin';

        }
        
            //echo $msg;
            error_reporting(E_ERROR | E_PARSE);

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/config_db/db_config.php';
   
    }


}