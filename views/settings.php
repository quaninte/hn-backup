<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HN Backup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    <div class="row">
        <div class="span6 offset3">
            <h1>HN Backup Settings</h1>
            <form action="" method="POST" class="form-horizontal">

                <?php
                foreach ($params as $key => $param) {
                ?>
                <div class="control-group">
                    <label class="control-label" for="input<?php echo $key;?>"><?php echo $param['title'];?></label>
                    <div class="controls">
                        <input name="settings[<?php echo $key; ?>]" type="text" id="input<?php echo $key;?>" placeholder="<?php echo $param['value'];?>" value="<?php echo getSetting($key); ?>">
                    </div>
                </div>
                <?php
                }
                ?>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div> <!-- /container -->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>