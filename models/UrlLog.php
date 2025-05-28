<?php

namespace app\models;

use yii\db\ActiveRecord;

class UrlLog extends ActiveRecord
{
    public static function tableName()
    {
        return 'url_log';
    }

    public function rules()
    {
        return [
            [['url_id'], 'required'],
            [['url_id'], 'integer'],
            [['ip_address'], 'string', 'max' => 45],
        ];
    }

    public function getUrl()
    {
        return $this->hasOne(Url::class, ['id' => 'url_id']);
    }
}
