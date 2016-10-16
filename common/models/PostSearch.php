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
     * @return array
     * 增加属性,让PostSearch实现按字符串查询
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['authorName']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'content', 'tags', 'authorName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     * 作废父类场景的方法:
     * 调用顶级类的场景覆盖之
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
        /**
         * 这个就是首先,select*,
         * 然后层层设置条件,最后查询
         */
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

        /**
         * 块赋值:
         * 把表单中的数据赋给 当前对象的属性
         */
        $this->load($params);

        /**
         * 判断提交的数据是否符合规则:
         * 如果不符合规则,就返回所有结果
         */
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            /**
             * 加上下面这个条件,可以达到的效果是:
             * 如果数据不符合规范,就不显示数据
             */
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
//            'id' => $this->id,
            'post.id' => $this->id,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        /**
         * 构建按字符串查询的查询器:
         * 1.连接用户表
         * 2.设置查询条件为:like模糊查询
         */
        $query->join('INNER JOIN', 'Adminuser', 'post.author_id = adminuser.id');
        $query->andFilterWhere(['like', 'Adminuser.nickname', $this->authorName]);

        /**
         * 实现关联表用户名的点击排序功能
         */
        $dataProvider->sort->attributes['authorName'] =
            [
                'asc' => ['Adminuser.nickname' => SORT_ASC],
                'desc' => ['Adminuser.nickname' => SORT_DESC],
            ];

        return $dataProvider;
    }
}
