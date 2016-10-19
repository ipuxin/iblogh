<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'content:ntext',
            [
                'attribute' => 'content',
                'value' => function ($model) {
                    //去掉html标签
                    $tmpStr = strip_tags($model->content);
                    //计算长度,为是否增加...做准备
                    $tmpLen = mb_strlen($tmpStr,'UTF-8');
                    //截取字符串
                    return mb_substr($tmpStr, 0, 20, 'utf-8') . (($tmpLen > 20) ? '...' : '');
                }
            ],
            'status',
            'create_time:datetime',
            'userid',
            // 'email:email',
            // 'url:url',
            // 'post_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
