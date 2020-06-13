<!doctype html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
<!--   <link rel="stylesheet" href="/monsite/webroot/css/calandar.css"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title><?php echo isset($tile_for_theme) ? $tile_for_theme : 'Mon site'; ?></title>
</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" style="position: static;">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault"  >
      <ul class="navbar-nav mr-auto">

        <!--la function request() Permet de charget  une vue de puis une page  -->
        <?php /**
         *@param le controller
         *@param non de l'action
         **/
        $pagesMenu = $this->request('Pages', 'getMenu');
        ?>
        <?php foreach ($pagesMenu as $p) : ?>
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo BASE_URL.'/pages/view/id:' . $p->id; ?>" title="<?php echo $p->name; ?>"><?php echo $p->name; ?></a>
          </li>
        <?php endforeach; ?>
        <!-- je cree un nouveau elemnt pour mon menu qui s'appelle actualité -->
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo Router::url('blog/index');?>">Actualité</a>
        </li>

      </ul> 
    </div>
  </nav>

  <div class="container">
    <style>
      .container {
        margin-top: 70px
      }
    </style>
    <?php echo $this->Session->flash();?>
    <?php echo $content_for_theme; ?>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>