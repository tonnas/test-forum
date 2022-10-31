<?php

/** @var Comment $comment */

use app\models\Comment;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<p <?= isset($level) ? 'style="margin-left:'. $level . 'px;"' : '' ?>>
    <span class="blockquote-footer">
        <?= Html::encode($comment->author) ?> 
        (<?= Html::encode($comment->created_at) ?>) 
    </span>
    <br>
    <?= Html::encode($comment->content) ?> |
    <?=
        Html::a('Reply', Url::to(['site/comment', 'parentId' => $comment->id]), [
            'class' => 'modalButton',
        ])
    ?>
</p>
