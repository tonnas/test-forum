<?php

use app\models\Article;
use app\models\Comment;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

/* @var yii\web\View $this */
/* @var yii\data\ActiveDataProvider $dataProvider */
/* @var Article $article */
/* @var Comment $commentModel */

Modal::begin([
    'id'=>'modal',
    'size'=>'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();

?>

<div class="wrap">
    <h1><?= Html::encode($article->title) ?></h1>
    <p class="mb-3"><?= Html::encode($article->content) ?></p>
    <p>
        <?=
            Html::button(
                'Create Comment',
                [
                    'value'=> Url::to(['admin/create']),
                    'class'=>'btn btn-success grid-button, modalButton'
                ])
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'parent_id',
            'author',
            'content',
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create} {update} {delete}',
                'buttons'=>[
                    'create' => function ($url) {
                        return Html::a ('Reply', $url, [
                            'class' => 'text-success modalButton'
                        ]) . '<br>';
                    },
                    'update' => function ($url) {
                        return Html::a('Update', $url, [
                                'class' => 'modalButton'
                            ]) . '<br>';
                    },
                    'delete' => function ($url) {
                        return Html::a('Delete', $url, [
                            'class' => 'text-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post'
                            ]
                        ]);
                    },
                ]
            ],
        ],
    ]);  ?>
</div>
