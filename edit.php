<?php
require_once('init.php');

if(empty($parsing_map)) {

  $url = get_base_url() . '/add-listing.php';

  require_once("redirect.php");
  exit;
}

error_reporting(E_ALL);

$storage_dir = dirname(__FILE__).DIRECTORY_SEPARATOR . 'file_storage' . DIRECTORY_SEPARATOR;

$file_list = array();

foreach($parsing_map as $map_item) {
  $file_list[$map_item['email']] = $map_item['reply_message_file'];
}

$file_list_flipped = array_flip($file_list);


$file_name = isset($_GET['file_name']) ? $_GET['file_name'] : reset($file_list);

$ok = (in_array($file_name, $file_list)) ? true : false;

if($ok == false)
  exit();

if(isset($_POST['submit'])){
  file_put_contents($storage_dir . $file_name, $_POST['new_content']);
}

$tab_content = file_get_contents($storage_dir . $file_name);
?>
<head>
<head>
  <meta charset="utf-8">
  <title>Edit - Email AutoResponder System</title>
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
  <script type="text/javascript" src="libraries/jquery.min.js"></script>
  <script type="text/javascript" src="libraries/ckeditor/ckeditor.js"></script>

  <script type="text/javascript">
    jQuery(document).ready(function() {
      CKEDITOR.editorConfig = function( config )
      {
        config.resize_enabled = false;
      };

      CKEDITOR.replace( 'ckeditor',
      {
        skin : 'office2003'
      });
      
    });

  </script>
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
                      <li>
                          <a href="index.php"><i class="icon-home icon-white"></i> Home</a>
                      </li>
                      <li>
                          <a href="manage-listing.php"><i class="icon-list-alt icon-white"></i> Email List</a>
                      </li>
                      <li class="active">
                          <a href="edit.php"><i class="icon-pencil icon-white"></i> Email List Edit</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </div>

  <div class="container">
      <div class="hero-unit">
          <h3>Editing : <?php echo $file_list_flipped[$file_name];?></h3>

          <a class="btn btn-primary" href="manage-listing.php"><i class="icon-list-alt icon-white"></i> Back to Email List</a>

          <br>
          <div style="clear: both;"></div>
          <br>

          <div class="main-content">

          <div class="form_container" style="width:960px; float:left;display:block">
              <form method="POST" action="edit.php<?php echo '?file_name='.$file_name;?>">
                  <textarea id="ckeditor" name="new_content"><?php echo $tab_content;?></textarea>

                  <input type="submit" style="float:right;margin: 20px 20px 0 0;" class="btn btn-primary btn-large" name="submit" value="SAVE &raquo;">
                  <div style="clear:both"></div>
              </form>
          </div>
          <div style="clear:both"></div>
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
</body>