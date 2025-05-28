<?php

namespace app\controllers;

use app\models\Url;
use app\models\UrlLog;
use Yii;
use yii\web\Controller;

class RedirectController extends Controller
{
    public function actionGo($code)
    {
        $url = Url::findOne(['short_code' => $code]);
        if (!$url) {
            throw new \yii\web\NotFoundHttpException('Ссылка не найдена');
        }

        $log = new UrlLog([
            'url_id' => $url->id,
            'ip_address' => Yii::$app->request->userIP,
        ]);
        $log->save();

        $url->updateCounters(['clicks' => 1]);

        return $this->redirect($url->original_url);
    }
}
