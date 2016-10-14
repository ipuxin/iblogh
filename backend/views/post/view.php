<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除么?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            //ntext:内容显示格式
            'content:html',
            'tags:ntext',
            //'status', 原来是把属性名和值放一起,这里分开
            [
                'label' => '状态',
                'value' => $model->status0->name,
            ],
//            'create_time:datetime',
            [
                'attribute' => 'create_time',
                'value' => date('Y-m-d', $model->create_time),
            ],
            'update_time:datetime',
//            'author_id',
            [
                //'attribute'=>'author_id' 这种方式等价于: 'author_id',
                'attribute' => 'author_id',
                'value' => $model->author->nickname,
                //重写标签
                'label' => '作者昵称'
            ]
        ],
        'template' => '<tr><th style="width:110px;">{label}</th><td>{value}</td></tr>',
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
    ]) ?>

</div>
