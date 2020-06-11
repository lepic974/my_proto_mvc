


<div class="page-header">
    <h1>Editer un article</h1>
</div>
<!-- <script type="text/javascript" src="/monsite/webroot/js/tinymce/jquery.tinymce.min.js"></script> -->
<script type="text/javascript" src="/monsite/webroot/js/tinymce/tinymce.min.js "></script>

<script>
    tinymce.init({
        selector: '#inputcontent',
        height: 500,
        plugins: [
            "image",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste imagetools wordcount"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image",
        content_css: '//www.tiny.cloud/css/codepen.min.css',
        images_upload_url: '/upload',
        images_upload_handler: function(blobInfo, success, failure) {
            var xhr, formData;


            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/upload');

            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);

        }
        
    });

</script>
<form action="<?php echo Router::url('admin/posts/edit/id:' . $id); ?>" method="post">

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

