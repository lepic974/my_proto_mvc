<div class="page-header">
    <h1><?php echo $total; ?>Articles</h1>
</div>
<a href="<?php echo Router::url('admin/posts/edit') ?>" class="btn btn-primary">Ajouter un article</a>
<table class="table table-dark">
    <thead>
        <tr>
            <th>ID</th>
            <th>En ligne ?</th>
            <th>Titre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($posts as $k => $v) : ?>
            <tr>
                <td><?php echo $v->id; ?></td>
                <td>
                    <span class="badge <?php echo ($v->online == 1) ? 'badge-success' : 'badge-danger'; ?>">

                        <?php echo ($v->online == 1) ? 'En ligne' : 'Hors ligne'; ?>

                    </span>
                </td>
                <td><?php echo $v->name; ?></td>
                <td>
                    <a href="<?php echo Router::url('admin/posts/edit/id:' . $v->id); ?>">Editer</a>
                    <a onclick="return confirm('Voulez vous vraiment supprimer ce contenu')" href="<?php echo Router::url('admin/posts/delete/id:' . $v->id); ?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

