<?php

namespace app\modules\news\controllers\admin;

use Yii;
use app\modules\news\models\NewsCategory;
use app\modules\news\models\NewsCategorySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\BaseAdminController;

/**
 * CategoryController implements the CRUD actions for NewsCategory model.
 */
class CategoryController extends BaseAdminController
{
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    */

    /**
     * Lists all NewsCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new NewsCategory();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single NewsCategory model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new NewsCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $searchModel = new NewsCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new NewsCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'dataProvider'=>$dataProvider
            ]);
        }
    }

    /**
     * Updates an existing NewsCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $searchModel = new NewsCategorySearch();
        $dataProvider = $searchModel->category($id);
        $model = $this->findModel($id);
        $oldparent = $model->parent;

        if ($model->load(Yii::$app->request->post())) {
            $Ccat = NewsCategory::find()->where(['parent'=> $model->id])->all();
            //Если есть дети
            if($Ccat){
                foreach($Ccat as $c){
                    $c->parent=$oldparent;
                    $c->save();
                }
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dataProvider'=>$dataProvider,
            ]);
        }
    }

    /**
     * Deletes an existing NewsCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the NewsCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return NewsCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NewsCategory::findOne($id)) !== null) {
            return $model;
        } else {
            //throw new NotFoundHttpException('The requested page does not exist.');
            return $this->redirect(['index']);
        }
    }
}
