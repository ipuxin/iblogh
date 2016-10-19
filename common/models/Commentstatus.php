<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "commentstatus".
 *
 * @property integer $id
 * @property string $name
 * @property integer $position
 *
 * @property Comment[] $comments
 */
class Commentstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commentstatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'position'], 'required'],
            [['position'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['status' => 'id']);
    }

    /**
     *评论审核状态下拉菜单
     */
    public static function getApprove(){
        return self::find()
            ->select(['name','id'])
            ->orderBy('position')
            ->indexBy('id')
            ->column();
    }
}
