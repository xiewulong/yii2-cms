<?php
namespace yii\cms\controllers\backend;

use Yii;
use yii\base\ActionEvent;
use yii\components\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class DashboardController extends Controller {

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['error'],
						'allow' => true,
					],
					[
						'actions' => ['fileupload', 'ueditor', 'ui'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['index'],
						'allow' => true,
						'roles' => $this->module->permissions,
					],
				],
			],
		];
	}

	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'fileupload' => [
				'class' => 'yii\fileupload\FileuploadAction',
			],
			'ueditor' => [
				'class' => 'yii\xui\UeditorAction',
			],
		];
	}

	public function actionIndex() {
		return $this->render($this->action->id);
	}

	public function actionUi() {
		if(YII_ENV == 'prod') {
			throw new NotFoundHttpException('Page not found.');
		}
		return $this->render($this->action->id);
	}

}
