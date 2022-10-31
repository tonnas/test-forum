<?php

namespace app\controllers;

use app\models\Comment;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Article;

class SiteController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
        $article = Article::first();
        $commentModel = new Comment();
        $comments = Comment::findAll([
            'article_id' => Article::FIRST_ARTICLE_ID,
            'parent_id' => null,
        ]);

        if ($commentModel->saveComment()) {
            $this->refresh();
        }

        return $this->render('index', [
            'commentModel' => $commentModel,
            'article' => $article,
            'comments' => $comments,
            'commentsCount' => Comment::find()->where(['article_id' => Article::FIRST_ARTICLE_ID])->count(),
        ]);
    }

    /**
     * @param $parentId
     * @return string
     */
    public function actionComment($parentId = null): string
    {
        $commentModel = new Comment();

        if ($commentModel->saveComment($parentId)) {
            $this->redirect('index');
        }

        return $this->renderAjax('commentForm', [
           'commentModel' => $commentModel,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/admin');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
