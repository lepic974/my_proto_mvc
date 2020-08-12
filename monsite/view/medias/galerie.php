<link rel="stylesheet" href="<?php echo Router::webroot('css/galerie.css') ?>">

<div class="galerie_imgListe cadre">

    <?php foreach ($galerie as $key => $value) : ?>

    <div>
        <a class="imageZoom " href="<?php echo Router::webroot('img/'.$value->url) ?>">
            <img class="galerie_imgPreview" src="<?php echo Router::webroot('img/'.$value->url) ?>" alt="">
        </a>
    </div>
    <?php endforeach ?>
  
</div>