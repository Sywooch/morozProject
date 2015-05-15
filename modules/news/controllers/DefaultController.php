<?php

namespace app\modules\news\controllers;

use yii\web\Controller;
//use app\modules\news\models\NewsCategory;
//use app\modules\news\models\News;
use yii\data\Pagination;
use yii\data\SqlDataProvider;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex(){

        // вот так семь запросов
        /*$query = News::find();
        $query->joinWith('newsCategory');
        $query->where(['news.visible' => 'Y']);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 2,'forcePageParam'=>false,'pageSizeParam'=>false]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        */
        // а вот так 2 запроса
        //$count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM news LEFT JOIN news_category ON news.news_category_id = news_category.id WHERE news.visible="Y"')->queryScalar();
        // почему то так нет кеширования
        /*$dataProvider = new SqlDataProvider([
            'sql' => 'SELECT news.* FROM news LEFT JOIN news_category ON news.news_category_id = news_category.id WHERE news.visible="Y"',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 2,
                'forcePageParam' => false,
                'pageSizeParam' => false
            ],
        ]);*/
        //$models = $dataProvider->getModels();



        //решение с кешированием
        //$pagination = new Pagination(['totalCount' => $count, 'pageSize'=>2,'forcePageParam' => false,'pageSizeParam' => false]);
        $duration = 100;     // кэширование результата на 100 секунд
        $db = Yii::$app->db;

        $models = $db->cache(function ($db) {
            $count = $db->createCommand('SELECT COUNT(*) FROM news LEFT JOIN news_category ON news.news_category_id = news_category.id WHERE news.visible="Y"')->queryScalar();
            $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>2,'forcePageParam' => false,'pageSizeParam' => false]);
            $params = [':offset' => $pagination->offset, ':limit' => $pagination->limit];
            $models = $db->createCommand('SELECT news.* FROM news LEFT JOIN news_category ON news.news_category_id = news_category.id WHERE news.visible="Y" LIMIT :offset,:limit')
                ->bindValues($params)
                ->queryAll();
            return array($models,$pagination);

        }, $duration);


        return $this->render('index', [
            'news' => $models[0],
            'pages' => $models[1],
        ]);
    }


    public function actionView()
    {
        return $this->render('view');
    }
}
