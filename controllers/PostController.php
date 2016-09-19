<?php
/**
 * Created by PhpStorm.
 * User: erlongchen88@gmail.com
 * Since: 2016/9/19 下午13:45:05
 */
namespace app\controllers;

use Yii;
use app\models\Post;

class PostController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $model = new Post;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            echo '该帖子的标题是' . $model->title . '<br><br>' . '内容是' . $model->content;
            die;
        }
        return $this->render('create', ['model' => $model]);
    }
}