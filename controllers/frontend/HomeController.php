<?php
namespace yii\cms\controllers\frontend;

use Yii;
use yii\cms\components\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class HomeController extends Controller {

	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'testLimit' => 1,
				'minLength' => 4,
				'maxLength' => 6,
				'fixedVerifyCode' => YII_ENV_TEST ? 'test' : null,
			],
		];
	}

	public function actionIndex() {
		return $this->accessed($this->module->statisticsEnable)->render($this->action->id);
	}

}
