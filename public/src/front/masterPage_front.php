<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $page_title?></title>
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

