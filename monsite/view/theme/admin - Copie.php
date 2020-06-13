<!doctype html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!--   <link rel="stylesheet" href="/monsite/webroot/css/calandar.css"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Le titre de la page -->
    <title><?php echo isset($tile_for_theme) ? $tile_for_theme : 'Administration'; ?></title>
</head>

<body class="bg bg-secondary">
<!-- Le menu -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" style="position: static;">


        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <h3>
                <a href="<?php echo Router::url('admin/posts/index'); ?>">Administration</a>
            </h3>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo Router::url('admin/posts/index'); ?>">Articles</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo Router::url('admin/pages/index'); ?>">Pages</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo Router::url('/'); ?>">Voir le site</a>

                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo Router::url('users/logout'); ?>">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </nav>
<!-- affiche les info de la flach -->
    <div class="container " style="padding-top:60px;">
        <?php echo $this->Session->flash(); ?>
        <?php echo $content_for_theme; ?>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>


</html>