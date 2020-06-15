<script type="text/javascript" src="/monsite/webroot/js/tinymce/tinymce.min.js "></script>
<script type="text/javascript" src="/monsite/webroot/js/tinymce/integration.js "></script>

<div class="page-header">
    <?php if (empty($id)) : ?>

        <h1>Crée un Article</h1>

    <?php elseif (!empty($id)) :  ?>

        <h1>Modifier un Article</h1>

    <?php endif ?>
</div>

<form action="<?php echo Router::url('admin/posts/post_edit/id:' . $id); ?>" method="post">

    <!-- le chanp name -->
    <?php echo $this->Form->input('name', 'Titre'); ?>
    <!-- Chanp slug Url fictive -->
    <?php echo $this->Form->input('slug', 'Url'); ?>
    <!-- id de l'article -->
    <?php echo $this->Form->input('id', 'hidden'); ?>

    <!-- le chanp contenue -->
    <?php echo $this->Form->input('content', 'Contenu', array('type' => 'textarea', 'class' => 'form-control')); ?>
    <!-- la check box pour mettre en ligne ou pas  -->
    <?php echo $this->Form->input('online', 'En ligne', array('type' => 'checkbox')); ?>

    <!-- Submit button -->
    <div class="actions">
        <input type="submit" class="btn btn-primary" value="Envoyer">
    </div>
</form>