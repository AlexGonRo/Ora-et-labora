<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $page_title?></title>
  
  <!-- Favicon for the browser tabs. From https://realfavicongenerator.net/-->
  <link rel="shortcut icon" href="../../img/public/oet_favicon/favicon.ico">
  <link rel="icon" type="image/png" sizes="32x32" href="../../img/public/oet_favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../img/public/oet_favicon/favicon-16x16.png">
  <link rel="manifest" href="../../img/public/oet_favicon/site.webmanifest">  <!--For android's menu-->
  <link rel="mask-icon" href="../../img/public/oet_favicon/safari-pinned-tab.svg" color="#5bbad5"> <!--For safary-->
  <link rel="apple-touch-icon" sizes="60x60" href="../../img/public/oet_favicon/apple-touch-icon.png"> <!--Apple phone-->
  <meta name="theme-color" content="#ffffff"> <!--For the iOS menu icon, I believe-->

  <link rel="shortcut icon" sizes="32x32" href="../../img/public/oet_favicon/favicon-32x32.png" type="image/png" />
  <link rel="shortcut icon" sizes="16x16" href="../../img/public/oet_favicon/favicon-16x16.png" type="image/png" />
  
  <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon.png">
  <meta name="msapplication-TileColor" content="#2d89ef">
  <meta name="theme-color" content="#ffffff">


  <!--Other meta information-->
  <?php echo $page_meta ?? ''?>

    <!-- --------- Load JQuery and Bootstrap -----------
    ---------------------------------------------------- -->
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <!-- jQuery local fallback -->
    <script>window.jQuery || document.write('<script src="../jquery/jquery-3.3.1.js"><\/script>')</script>
    <!-- Bootstrap JS CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- Bootstrap JS local fallback -->
    <script>if(typeof($.fn.modal) === 'undefined') {document.write('<script src="../bootstrap-4.1.3/js/bootstrap.min.js"><\/script>')}</script>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Bootstrap CSS local fallback -->
    <div id="bootstrapCssTest" class="hidden"></div>
    <script>
      $(function() {
        if ($('#bootstrapCssTest').is(':visible')) {
          $("head").prepend('<link rel="stylesheet" href="../boostrap-4.1.3/css/boostrap.min.css">');
        }
      });
    </script>
    <!-- ---------------------------------------------------
    ---------------------------------------------------- -->
    <!--LOCAL CSS style page -->
    <link rel="stylesheet" href="../css/style.css">
    <!--My JS scripts-->
    <?php echo $my_js_scripts ?? ''; ?>
    
    
    
</head>

<body>
   
  <?php require 'tmpl/front_navbar.php'; ?>
    
  <main role="main">
      
      <?php echo $content_html; ?>

  </main>

<?php require 'tmpl/footer.php'; ?>


</body>
</html>

