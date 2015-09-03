<?php

namespace app\controllers;

use app\models\Category;
use app\models\Entry;
use app\models\EntryTag;
use app\models\Tag;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use kartik\markdown\Markdown;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->renderContent(null);
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionGetallentries()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Category::getPreparedJsonEntries();
    }

    public function actionCreatecategory()
    {
        $name = Yii::$app->request->post('name');
        $category = Yii::$app->request->post('category');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cat = new Category();
        $cat->name = $name;
        $cat->subcategory = $category;
        $cat->save();
        return $cat->id;
    }

    public function actionCreateentry()
    {
        $name = Yii::$app->request->post('name');
        $body = Yii::$app->request->post('body');
        $category = Yii::$app->request->post('category');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $entry = new Entry();
        $entry->name = $name;
        $entry->body =  Markdown::convert($body);
        $entry->category = $category;
        $entry->save();
        $tag = EntryTag::setTags($entry->id, Yii::$app->request->post('tags'));
        return $tag;
    }

    public function actionDeleteentry()
    {
        $id = Yii::$app->request->post('id');
            $model = Entry::findOne($id)->delete();
    }

    public function actionDeletecategory()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        return count($id) > 0? Category::deleteAll(['id' => $id]): 0;
    }

    public function actionGetentry()
    {
        $id = Yii::$app->request->get('id');
        $tags = EntryTag::findAll(['entry_id' => $id]);
        $retTags = [];
        // TODO relations
        foreach ($tags as $k=>$v) {
            $retTags[] = Tag::findOne($v['tag_id']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return (object)['data' => Entry::findOne($id), 'tags' => $retTags];
    }

    public function actionGettags()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Tag::find()->all();
    }
}