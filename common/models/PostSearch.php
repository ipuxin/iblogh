<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'content', 'tags'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

            /**
             * 指定分页
             */
            'pagination' => ['pageSize' => 5],

            /**
             * 指定排序
             */
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],

                /*
                 * 设定可以排序的字段
                 */
                'attributes' => ['id', 'title'],
            ],
        ]);

        echo "<pre>";
        print_r($dataProvider->getPagination());
        /**
         * 显示分页信息:
         * $dataProvider->getPagination()
         * yii\data\Pagination Object
         * (
         * [pageParam] => page
         * [pageSizeParam] => per-page
         * [forcePageParam] => 1
         * [route] =>
         * [params] =>
         * [urlManager] =>
         * [validatePage] => 1
         * [totalCount] => 0
         * [defaultPageSize] => 20
         * [pageSizeLimit] => Array
         * (
         * [0] => 1
         * [1] => 50
         * )
         *
         * [_pageSize:yii\data\Pagination:private] => 5
         * [_page:yii\data\Pagination:private] =>
         * )
         */


        echo "<hr>";
        print_r($dataProvider->getSort());
        /**
         * 指定哪些可以排序
         * $dataProvider->getSort()
         * yii\data\Sort Object
         * (
         * [enableMultiSort] =>
         * [attributes] => Array
         * (
         * [id] => Array
         * (
         * [asc] => Array
         * (
         * [id] => 4
         * )
         *
         * [desc] => Array
         * (
         * [id] => 3
         * )
         *
         * [label] => ID
         * )
         *
         * [title] => Array
         * (
         * [asc] => Array
         * (
         * [title] => 4
         * )
         *
         * [desc] => Array
         * (
         * [title] => 3
         * )
         *
         * [label] => 标题
         * )
         *
         * )
         *
         * [sortParam] => sort
         * [defaultOrder] => Array
         * (
         * [id] => 3
         * )
         *
         * [route] =>
         * [separator] => ,
         * [params] =>
         * [urlManager] =>
         * [_attributeOrders:yii\data\Sort:private] =>
         * )
         */

        echo "<hr>";
        /**
         * 当前页的数据条数
         */
        print_r($dataProvider->getCount());
        echo "<hr>";
        print_r($dataProvider->getTotalCount());

        echo "</pre>";
        exit(0);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        return $dataProvider;
    }
}
