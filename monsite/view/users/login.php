<div class="header">
    <h1>Zone réservé</h1>
</div>
<!-- je crée un Formulaire de Connection  -->
<form action="<?php echo Router::url('users/login'); ?>" method="post">

    <?php echo $this->Form->input('login', 'Identifiant'); ?>

    <?php echo $this->Form->input('password', 'Mot de passe', array('type' => 'password')); ?>
    <!-- Le bouton de validation -->
    <div class="actions">
        <br>
        <input type="submit" class="btn btn-primary">
    </div>
</form>
