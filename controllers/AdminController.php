<?php

namespace app\controllers;

use app\helpers\CommentHelper;
use Yii;
use Throwable;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Article;
use app\models\Comment;

class AdminController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->where(['article_id' => Article::FIRST_ARTICLE_ID]),
        ]);
        $commentModel = new Comment();

        if ($commentModel->saveComment()) {
            $this->refresh();
        }

        return $this->render('index', [
            'commentModel' => $commentModel,
            'article' => Article::first(),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionCreate($id = null): string
    {
        $commentModel = new Comment();

        if ($commentModel->saveComment($id)) {
            $this->redirect('index');
        }

        return $this->renderAjax('commentForm', [
            'commentModel' => $commentModel,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionUpdate($id): string
    {
        $commentModel = Comment::findOne(['id' => $id]);

        if ($commentModel->saveComment()) {
            $this->redirect('index');
        }

        return $this->renderAjax('commentForm', [
            'commentModel' => $commentModel,
        ]);
    }

    /**
     * @param $id
     * @return void
     */
    public function actionDelete($id): void
    {
        try {
            CommentHelper::cascadeDelete($id);
        } catch (Throwable $e) {
            Yii::error($e->getMessage());
        }

        $this->redirect('index');
    }
}
