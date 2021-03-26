<?php
/** @var \app\models\Posts $post */
/** @var \app\models\PostComments $postCommentsModel */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

?>

<div class="raw">
    <div class="col-md-4"><img src="<?=$post->file_path?>"/></div>
    <div class="col-md-8"><p><?=$post->full_text?></p></div>
</div>

<?php foreach ($post->comments as $comment):?>
    <div class="raw">
        <div class="col-md-4"><?=$comment->email?></div>
        <div class="col-md-8"><p><?=$comment->comment?></p></div>
    </div>
<?php endforeach;?>

<div class="raw">
    <div class="col-md-4">
        <h2>You may send a comment</h2>
        <?php $form = ActiveForm::begin([
            'id' => 'postCommentForm',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'action' => ['blog/send-comment/' . $post->id],
        ]); ?>

        <?= $form->field($postCommentsModel, 'email')->textInput() ?>

        <?= $form->field($postCommentsModel, 'comment')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJsFile("@web/js/blog_view.js",[
    'position' => \yii\web\View::POS_END,
    'defer' => true
]);
?>