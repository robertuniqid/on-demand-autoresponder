<?php require_once('init.php');

 if(empty($parsing_map)) {

   $url = get_base_url() . '/add-listing.php';

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
                    <li class="active">
                        <a href="index.php"><i class="icon-home icon-white"></i> Home</a>
                    </li>
                    <li>
                        <a href="manage-listing.php"><i class="icon-list-alt icon-white"></i> Email List</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="hero-unit">
        <h3>Email Auto-Responder Script</h3>

        <div class="main-content">

            <table class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Email Address</th>
                    <th>Emails Delivered so far</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;foreach($parsing_map as $k => $parse_information) : ?>
                  <tr>
                      <td><input id="email-marker-<?php echo $i;?>"
                                 type="checkbox"
                                 class="email-marker checkbox"
                                 name="email-marker[]"
                                 value="<?php echo $parse_information['email'];?>"></td>
                      <td><label for="email-marker-<?php echo $i;?>"><?php echo $parse_information['email'] ?></label></td>
                      <td>
                        <label for="email-marker-<?php echo $i;?>">
                          <?php $c = Model_Operation_FileStorage::getInstance()->fetchInformation($parse_information['reply_message_track']);?>
                          <?php echo is_array($c) ? count($c) : 0;?>
                        </label>
                      </td>
                  </tr>
                <?php $i++;endforeach;?>
                </tbody>
            </table>
            <div id="run-script-error" class="alert-error" style="display:none;padding: 0 0 0 20px;border-radius: 5px;width:300px;margin: 0 auto;">
                Please select at least one email !
            </div>
          <p style="float:right;"><a id="run-script" href="#" class="btn btn-primary btn-large">Start &raquo;</a></p>

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
    $('input.email-marker').click(function(event){
      if($(this).is(':checked'))
        $(this).parents('tr').addClass('success');
      else
        $(this).parents('tr').removeClass('success');
    });

    $('#run-script').click(function(event){
      event.preventDefault();

      var elements = $('input.email-marker:checked');

      if(!(elements.length > 0)) {
          $('#run-script-error').slideDown('slow');

          return false;
      }

      $('#run-script-error').slideUp('slow');

      $('div.main-content').slideUp('slow', function(event){
        var html = '<p class="alert-info" style="padding: 0 0 0 20px;border-radius: 5px;width:450px;margin: 0 auto;">Your request is being processed please wait !</p>';
        $(this).html(html);

        $(this).slideDown('slow', function(event){
            $.ajax({
                type: "POST",
                url: 'script_run.php',
                data: elements.serialize(),
                success: function(response){
                    $('div.main-content').slideUp('slow', function(event){
                        $(this).html(response);
                        $(this).slideDown('slow');
                    });
                },
                dataType: 'html'
            });
        });
      });
    });

    $("#show-emails-container").live('click', function(event){
      $("#sent-emails-container").slideDown('slow');
      $(this).slideUp('slow');
    });
</script>

</body>
</html>
