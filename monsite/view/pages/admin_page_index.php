<div >
    <a href="<?php echo Router::url('admin/pages/page_edit') ?>" class="btn btn-success btn-icon-split">
        <span class="icon text-white-50"><i class="fas fa-arrow-right"></i></span>
        <span class="text">Ajouter une page </span>
    </a>
</div>
<hr class="sidebar-divider my-3">

<div class="card shadow mb-4">
    <div class="card-header py-3 ">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $total; ?>Pages</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>En ligne ?</th>
                        <th>ID</th>

                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($pages as $_key => $_value) : ?>
                        <tr>
                            <td><?php echo $_value->name; ?></td>

                            <td>
                                <span class="badge <?php echo ($_value->online == 1) ? 'badge-success' : 'badge-danger'; ?>">

                                    <?php echo ($_value->online == 1) ? 'En ligne' : 'Hors ligne'; ?>

                                </span>
                            </td>
                            <td><?php echo $_value->id; ?></td>

                            <td>
                                <a class="btn btn-warning btn-icon-split" href="<?php echo Router::url('admin/pages/page_edit/id:' . $_value->id); ?>">
                                    <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
                                    <span class="text">Editer l'a page</span>
                                </a>
                                <span class="icon text-white-50">&spades</span>
                                <a class="btn btn-danger btn-icon-split" onclick="return confirm('Voulez vous vraiment supprimer ce contenu')" href="<?php echo Router::url('admin/pages/delete/id:' . $_value->id); ?>">
                                    <span class="icon text-white-50"><i class="fas fa-trash"></i></span>
                                    <span class="text">Spupprimer la page</span>
                                </a>

                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>