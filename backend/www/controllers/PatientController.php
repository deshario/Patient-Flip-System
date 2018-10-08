<?php

namespace app\controllers;

use app\models\PatientTurning;
use Yii;
use app\models\PatientInfo;
use app\models\PatientInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * PatientInfoController implements the CRUD actions for PatientInfo model.
 */
class PatientController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PatientInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PatientInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PatientInfo model.
     * @param integer $id
     * @return mixed
     */
     public function actionView($id)
     {
         // return $this->render('view', [
         //     'model' => $this->findModel($id),
         // ]);

         return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
     }

     public function actionViewturn($id)
     {
         $connection = \Yii::$app->db;
         $model = $connection->createCommand(
             'SELECT * FROM patient_turning INNER JOIN patient_info ON patient_turning.P_id = patient_info.patient_id 
                   WHERE patient_info.patient_id = '.$id.' ORDER BY patient_turning.latest_turned DESC');
         $dataProvider = $model->queryAll();
         return $this->renderAjax('view_turning', [
             'dataProvider' => $dataProvider,
         ]);
     }

    /**
     * Creates a new PatientInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PatientInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->patient_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PatientInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->patient_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PatientInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PatientInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatientInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id){
        if (($model = PatientInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findTurning($id){
        if (($model = PatientTurning::findAll($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
