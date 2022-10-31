<?php

use app\models\Article;
use app\models\Comment;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var Comment $commentModel */

$author = Yii::$app->user->isGuest ? 'Anonymous' : Yii::$app->user->identity->username;

$form = ActiveForm::begin([
    'id' => 'comment-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>

<?= $form->field($commentModel, 'article_id')->hiddenInput(['value' => Article::FIRST_ARTICLE_ID])->label(false) ?>

<div class="mb-3">
    <?= $form->field($commentModel, 'author')->textInput(['value' => $author]) ?>
</div>

<div class="mb-3">
    <?= $form->field($commentModel, 'content')->textarea(['rows' => 3]) ?>
</div>

<div class="form-group mb-3">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Public comment', ['class' => 'btn btn-sm btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>
