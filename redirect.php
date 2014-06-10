<!DOCTYPE html>
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
                    <li class="">
                        <a href="edit.php"><i class="icon-pencil icon-white"></i> Edit</a>
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

            <h2>Please wait ...</h2>
            <script>
                document.location = '<?php echo $url?>';
            </script>

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
</body>
</html>
