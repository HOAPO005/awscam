<?php
  require_once '../app/config/config.php';
  require_once APPROOT . '/helpers/session_helper.php';
  require_once APPROOT . '/helpers/url_helper.php';

  // Autoload Core Libraries
  spl_autoload_register(function($className){
    require_once APPROOT . '/core/' . $className . '.php';
  });

  // Init Core Library
  $init = new App();
