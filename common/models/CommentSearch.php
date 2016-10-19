<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `common\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * id->字符串搜索---2
     * @return array
     * 添加搜索属性
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['user.username', 'post.title']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'userid', 'post_id'], 'integer'],
            [['content', 'email', 'url', 'user.username', 'post.title'], 'safe'],
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
        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'comment.id' => $this->id,
            'comment.status' => $this->status,
            'create_time' => $this->create_time,
            'userid' => $this->userid,
            'post_id' => $this->post_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'url', $this->url]);

        /**
         * 实现用户姓名的搜索
         * 构建按字符串查询的查询器:
         * 1.连接用户表
         * 2.设置查询条件为:like模糊查询
         */

        $query->join('INNER JOIN', 'user', 'comment.userid = user.id');
        $query->andFilterWhere(['like', 'user.username', $this->getAttribute('user.username')]);

        /**
         * 实现关联表用户名的点击排序功能
         */
        $dataProvider->sort->attributes['user.username'] =
            [
                'asc' => ['user.username' => SORT_ASC],
                'desc' => ['user.username' => SORT_DESC],
            ];

        /**
         * 实现文章标题的搜索
         */
        $query->join('INNER JOIN', 'post', 'comment.post_id = post.id');
        $query->andFilterWhere(['like', 'post.title', $this->getAttribute('post.title')]);

        /**
         * 实现关联表用户名的点击排序功能
         */
        $dataProvider->sort->attributes['post.title'] =
            [
                'asc' => ['post.title' => SORT_ASC],
                'desc' => ['post.title' => SORT_DESC],
            ];

        /**
         * 实现关联表用户名的点击排序功能
         */
        $dataProvider->sort->defaultOrder =
            [
                'status' => SORT_ASC,
                'id' => SORT_DESC,
            ];

        return $dataProvider;
    }
}
