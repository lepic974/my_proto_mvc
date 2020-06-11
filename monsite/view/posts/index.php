<div class="page-header">
  <h1>Le Blog</h1>
</div>
<!-- je parcoure les dirent Post  -->
<?php foreach ($posts as $k => $v) : ?>
  <!-- j'affiche le non du post  -->
  <h2> <?php echo $v->name; ?></h2>
  <!-- j'affiche le contenue du post -->
  <?php echo $v->content; ?>
  <!-- je créer un paragraphe qui sera un lien verre le Post (&rarr cest pour metre une fleche) -->
  <p><a href="<?php echo Router::url("posts/view/id:{$v->id}/slug:$v->slug");?>">Lire la suite &rarr;</a></p>
  <!-- je ferme ma boucle -->
<?php endforeach; ?>

<!-- PAGINATION -->
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <!-- je parcoure les post contenu dans la variable page -->
    <?php for ($i = 1; $i <= $page; $i++) : ?>
      <!-- jaffiche un numero pour chaque page disponible  -->
      <li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i ?></a></li>
      <!-- fin de la boucle  -->
    <?php endfor; ?>

  </ul>
</nav>