<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '评论管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            [
                'label' => '文章标题',
                'attribute' => 'id',
                'value' => $model->post->title,
            ],
            'content:ntext',
//            'status',
            [
                'attribute' => 'status',
                'value' => $model->status0->name,
            ],
            /**
             * Yii2时间格式化
             */
            'create_time:datetime',
            [
                'attribute' => 'create_time',
                'format'=>['date','php:Y-m-d h:i:s']
            ],
//            'author_id',
            [
                'attribute' => 'author_id',
                'value' => $model->user->username,
                //重写标签
                'label' => '作者昵称'
            ],
            'email:email',
            'url:url',
            'post_id',
        ],
    ]) ?>

</div>
