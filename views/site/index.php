<?php

/** @var View $this */
/** @var Article $article */
/** @var Comment[] $comments */
/** @var Comment $commentModel */
/** @var int $commentsCount */

use app\helpers\CommentHelper;
use app\models\Article;
use app\models\Comment;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Discussion';

Modal::begin([
    'title' => 'Reply',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<div class="site-index">

    <div class="jumbotron bg-transparent">
        <?php if ($article): ?>
            <h1 class="display-4"><?= Html::encode($article->title) ?></h1>

            <p class="lead"><?= Html::encode($article->created_at) ?></p>

            <p><?= Html::encode($article->content) ?></p>

            <p><?= $commentsCount . ($commentsCount == 1 ? ' comment' : ' comments') ?> </p>

            <?php if ($comments): ?>
                <?=
                    Html::button('Reply to article', [
                        'class' => 'btn btn-sm btn-primary modalButton mb-3',
                        'value' => Url::to([ 'site/comment' ]),
                    ])
                ?>

                <?php foreach ($comments as $comment): ?>
                    <?= $this->render('commentView', [
                        'comment' => $comment,
                    ]) ?>

                    <?php CommentHelper::cascadeView($comment) ?>
                <?php endforeach; ?>

            <?php else: ?>
                <?= $this->render('commentForm', [
                    'commentModel' => $commentModel,
                ]) ?>
            <?php endif; ?>

        <?php else: ?>
            <h1 class="display-4">There is no article found</h1>
        <?php endif; ?>
    </div>
</div>
