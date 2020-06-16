<div>
    <a href="<?php echo Router::url('admin/posts/post_edit') ?>" class="btn btn-success btn-icon-split">
        <span class="icon text-white-50"><i class="fas fa-arrow-right"></i></span>
        <span class="text">Ajouter un article</span>
    </a>
</div>
<hr class="sidebar-divider my-3">
<div class="card shadow mb-4">
    <div class="card-header py-3 ">
        <h6 class="m-0 font-weight-bold text-primary">Articles</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>Titre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($images as $k => $v) : ?>
                        <tr>
                            <td><?php echo $v->name; ?></td>
                            <td>
                                <a href="#" onclick="insert('<?php echo Router::webroot('img/' . $v->file); ?>')">
                                    <img class="img" src="<?php echo Router::webroot('img/' . $v->file); ?>" height="100" alt="">
                                </a>
                            </td>
                    
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function insert(url) {
        window.parent.postMessage({
            mceAction: 'customAction',
            url: url
        }, '*');
    }
</script>