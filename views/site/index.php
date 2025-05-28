<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Сервис коротких ссылок';
?>
<div class="container mt-5">
    <h1>Сервис коротких ссылок</h1>
    <form id="shorten-form" class="form-inline mb-3">
        <input type="text" class="form-control mr-2" id="url-input" placeholder="Введите URL" required>
        <button type="submit" class="btn btn-primary">ОК</button>
    </form>
    <div id="result" class="mt-4"></div>
</div>

<?php
$this->registerJsFile('@web/js/shortener.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>