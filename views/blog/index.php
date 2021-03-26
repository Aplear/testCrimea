<div class="container">

    <div class="row">

        <?php foreach ($posts as $post):?>
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="<?=$post->file_path?>" data-holder-rendered="true">
                    <div class="card-body">
                        <p class="card-text"><?=substr($post->full_text, 0, 32)?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="/blog/view/<?=$post->id?>" class="btn btn-sm btn-outline-secondary">View</a>
                            </div>
                            <small class="text-muted">Author <?=$post->author?> time: <?=date('Y-m-d :h:i', $post->created_at)?> </small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>

    </div>
</div>