<?php

/**
 *   Example for a simple cas 2.0 client
 *
 * PHP Version 5
 *
 * @file     example_simple.php
 * @category Authentication
 * @package  PhpCAS
 * @author   Joachim Fritschi <jfritschi@freenet.de>
 * @author   Adam Franco <afranco@middlebury.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link     https://wiki.jasig.org/display/CASC/phpCAS
 */
require_once '/config.php';
// Load the CAS lib
require_once '/CAS.php';

// Enable debugging
phpCAS::setDebug("D:cas_error_log.log");
// Enable verbose error messages. Disable in production!
phpCAS::setVerbose(true);

// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0,'localhost' , 8080, 'cas');

phpCAS::setNoCasServerValidation();

phpCAS::handleLogoutRequests(false,true);

// force CAS authentication
phpCAS::forceAuthentication();

// $param=array("service"=>"http://onehundred.com");
if (isset($_REQUEST['logout'])) {
	phpCAS::logout();
}

?>
<html>
  <head>
    <title>phpCAS simple client</title>
  </head>
  <body>
    <h1>Successfull Authentication!</h1>
    <?php require 'script_info.php' ?>
    <p>the user's login is <b><?php echo phpCAS::getUser(); ?></b>.</p>
    <p>the user's star is <b><?php echo phpCAS::getAttribute("memberId"); ?></b>.</p>
    <p>phpCAS version is <b><?php echo phpCAS::getVersion(); ?></b>.</p>
    <p><a href="?logout=">Logout</a></p>
  </body>
  <script type="text/javascript">
    // if(window.location.host != 'onehundred.com'){
    //   window.location.href="http://onehundred.com";
    // }
  </script>
</html>
