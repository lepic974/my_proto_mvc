<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- 404 Error Text -->
    <div class="text-center">
        <div class="error mx-auto" data-text="404">404</div>
        <p class="lead text-gray-800 mb-5">PAGE INTROUVABLE</p>
        <p><?php echo $message; ?></p>
        <p class="text-gray-500 mb-0">il semble que vous ayez trouvé un problème dans la matrix...</p>
        <a href="<?php Router::url('')?>">&larr; Retourner au site</a>
    </div>

</div>
