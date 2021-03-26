<?php

namespace app\controllers;

use app\models\PostComments;
use app\models\Posts;
use Yii;
use app\models\search\PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * BlogController actions for Posts model.
 */
class BlogController extends Controller
{

    /**
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'posts' => $dataProvider->getModels(),
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $postCommentsModel = new PostComments();
        return $this->render('view', [
            'post' => $this->findModel($id),
            'postCommentsModel' => $postCommentsModel
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionSendComment($id)
    {
        if(Yii::$app->request->isAjax) {
            $model = new PostComments();
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
                $model->setAttribute('post_id', $id);
                $model->save();
            }
        }
        return false;
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
