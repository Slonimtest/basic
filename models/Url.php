<?php

namespace app\models;

use yii\db\ActiveRecord;

class Url extends ActiveRecord
{
    public static function tableName()
    {
        return 'url';
    }

    public function rules()
    {
        return [
            [['original_url', 'short_code'], 'required'],
            [['original_url'], 'string'],
            [['short_code'], 'string', 'max' => 10],
            [['short_code'], 'unique'],
        ];
    }

    public function getLogs()
    {
        return $this->hasMany(UrlLog::class, ['url_id' => 'id']);
    }
}
