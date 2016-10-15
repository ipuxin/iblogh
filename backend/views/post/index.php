<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <!--//把数据传递到testPost文件中-->
<?= $this->render('testPost',['test_arr'=>'hello testPost!']) ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'content:ntext',
            'tags:ntext',
            'status',
            // 'create_time:datetime',
            // 'update_time:datetime',
            // 'author_id',

            /*
             * 遗留问题,怎么从标题进入查看内容
             */
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
