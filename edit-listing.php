<?php
require_once('init.php');

if(!isset($_GET['email'])) {
  $url = get_base_url() . '/manage-listing.php';

  require_once("redirect.php");
  exit;
}

if(!isset($parsing_map[$_GET['email']] )) {
  $url = get_base_url() . '/manage-listing.php';

  require_once("redirect.php");
  exit;
}

$current_info = $parsing_map[$_GET['email']];

if(isset($_POST['info'])) {

  $parsing_map[$current_info['email']] = array_merge($current_info, $_POST['info']);

  Model_Operation_FileStorage::getInstance()->storeInformation('map.txt', $parsing_map);

  $url = get_base_url() . '/manage-listing.php?edit-listing=true';

  require_once("redirect.php");
  exit;
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Email AutoResponder System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="brand">Email System</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="">
                        <a href="index.php"><i class="icon-home icon-white"></i> Home</a>
                    </li>
                    <li class="active">
                        <a href="manage-listing.php"><i class="icon-list-alt icon-white"></i> Email List</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="hero-unit">
        <p style="display: inline-block;"><a href="manage-listing.php" class="btn btn-primary btn-large"> &laquo; Back</a></p>
        <h3 style="display: inline-block;margin: 0 0 0 160px;">Edit Listing</h3>

        <div class="main-content">

            <form method="POST">

                <div class="control-group">
                    <label class="control-label" for="host">Incoming Server (IMAP SSL, don't add port)</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-globe"></i></span>
                            <input class="span4" id="host" name="info[host]" type="text" required="required" placeholder="mail.yourdomain.tld" value="<?php echo $current_info['host']?>">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email_address">Email address</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-envelope"></i></span>
                            <input class="span4" id="email_address" name="info[email]" type="email" disabled="disabled" value="<?php echo $current_info['email']?>">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span>
                            <input class="span4" id="password" name="info[password]" type="text" required="required" value="<?php echo $current_info['password']?>">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="reply_name">Email Owner Name</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-arrow-right"></i></span>
                            <input class="span4" id="reply_name" name="info[reply_name]" type="text" required="required" value="<?php echo $current_info['reply_name']?>">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="reply_title">Reply Title</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-arrow-right"></i></span>
                            <input class="span4"
                                   id="reply_title"
                                   name="info[reply_title]"
                                   type="text"
                                   placeholder="Leave this empty to act like a reply"
                                   value="<?php echo $current_info['reply_title']?>">
                        </div>
                    </div>
                </div>

                <div style="margin: 0 0 0 200px;">
                    <a href="manage-listing.php" class="btn">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            <div class="clear"></div>
        </div>


    </div>

    <footer>
        <p>&copy; Easy-Development 2013</p>
    </footer>

</div> <!-- /container -->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.7.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">

</script>

</body>
</html>
