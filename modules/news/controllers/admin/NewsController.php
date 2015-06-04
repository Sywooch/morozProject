<?php

namespace app\modules\news\controllers\admin;

use Yii;
use app\modules\news\models\News;
use app\modules\news\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\components\BaseAdminController;
use yii\imagine\Image;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends BaseAdminController
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
    }*/

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'img');

            if ($model->file && $model->validate()) {
                $nameFile = Yii::$app->security->generateRandomString();
                $model->file->saveAs(Yii::$app->params['uploadPathNews']. $nameFile . '.' . $model->file->extension);
                // resize to width 200px
                $img = Image::getImagine()->open(Yii::getAlias(Yii::$app->params['uploadPathNews'] . $nameFile . '.' . $model->file->extension));
                $size = $img->getSize();
                //$ratio = $size->getWidth()/$size->getHeight();
                //$width = 200;
                //$height = round($width/$ratio);
                $ratio = $size->getHeight() / $size->getWidth();
                $height = 132;
                $width = round($height/$ratio);

                Image::thumbnail(Yii::$app->params['uploadPathNews']. $nameFile . '.' . $model->file->extension,$width,$height)->save(Yii::$app->params['uploadPathNews'] .'trumbs/' ."trumb_". $nameFile . '.' . $model->file->extension);
                $model->img = $nameFile . '.' . $model->file->extension;
            }
            $model->save();


            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldName = $model->img;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'img');
            if ($model->file && $model->validate()) {
                //delete old files images
                if (file_exists(Yii::$app->params['uploadPathNews'].$oldName)) {
                    unlink(Yii::$app->params['uploadPathNews'].$oldName);
                }
                if (file_exists(Yii::$app->params['uploadPathNews'].'trumbs/' ."trumb_".$oldName)) {
                    unlink(Yii::$app->params['uploadPathNews'].'trumbs/' ."trumb_".$oldName);
                }
                $nameFile = Yii::$app->security->generateRandomString();
                $model->file->saveAs(Yii::$app->params['uploadPathNews']. $nameFile . '.' . $model->file->extension);
                // resize to width 200px
                $img = Image::getImagine()->open(Yii::getAlias(Yii::$app->params['uploadPathNews'] . $nameFile . '.' . $model->file->extension));
                $size = $img->getSize();
                //$ratio = $size->getWidth()/$size->getHeight();
                //$width = 200;
                //$height = round($width/$ratio);
                // resize to height 132px
                $ratio = $size->getHeight() / $size->getWidth();
                $height = 132;
                $width = round($height/$ratio);

                Image::thumbnail(Yii::$app->params['uploadPathNews']. $nameFile . '.' . $model->file->extension,$width,$height)->save(Yii::$app->params['uploadPathNews'] .'trumbs/' ."trumb_". $nameFile . '.' . $model->file->extension);
                $model->img = $nameFile . '.' . $model->file->extension;
            }else{
                $model->img = $oldName;
            }
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
