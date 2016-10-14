<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = '文章修改: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>
<!--与新增公用一个表单,所以,此处把表单公用,可以参考此类用法-->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
