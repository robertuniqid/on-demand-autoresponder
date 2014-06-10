<?php require_once('init.php');
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
        <h3>Email Auto-Responder Script</h3>

        <div class="main-content">

            <p style="float:left;margin: 0 10px 0 10px;"><a href="index.php" class="btn btn-primary btn-large"> &laquo; Back</a></p>

            <p style="float:left;"><a href="add-listing.php" class="btn btn-primary btn-large">New &raquo;</a></p>

            <div style="clear:both"></div>

            <?php if(!empty($parsing_map)) : ?>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Email Address</th>
                    <th>Emails Delivered so far</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;foreach($parsing_map as $k => $parse_information) : ?>
                <tr>
                    <td><?php echo $parse_information['email'] ?></td>
                    <td>
                      <?php $c = Model_Operation_FileStorage::getInstance()->fetchInformation($parse_information['reply_message_track']);?>
                      <?php echo is_array($c) ? count($c) : 0;?>
                    </td>
                    <td>
                        <a href="edit.php?file_name=<?php echo $parse_information['reply_message_file'] ?>" class="btn btn-primary">Edit Email &raquo;</a>
                        <a href="edit-listing.php?email=<?php echo $parse_information['email'] ?>" class="btn">Edit Settings &raquo;</a>
                    </td>
                </tr>
                  <?php $i++;endforeach;?>
                </tbody>
            </table>

            <?php endif;?>

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
