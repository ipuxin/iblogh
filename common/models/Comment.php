<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property integer $userid
 * @property string $email
 * @property string $url
 * @property integer $post_id
 *
 * @property Post $post
 * @property Commentstatus $status0
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * 用于临时显示的属性
     */
    private $label_id;
    private $label_create_time;
    private $label_post_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'status', 'userid', 'email', 'post_id'], 'required'],
            [['content'], 'string'],
            [['status', 'create_time', 'userid', 'post_id'], 'integer'],
            [['email', 'url'], 'string', 'max' => 128],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Commentstatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'status' => '状态',
            'create_time' => '发布时间',
            'userid' => '用户',
            'email' => 'Email',
            'url' => 'Url',
            'post_id' => '文章',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Commentstatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    /**
     * @return string
     * 截取字符串
     */
    public function getBeginning()
    {
        //去掉html标签
        $tmpStr = strip_tags($this->content);
        //计算长度,为是否增加...做准备
        $tmpLen = mb_strlen($tmpStr, 'UTF-8');
        //截取字符串
        return mb_substr($tmpStr, 0, 10, 'utf-8') . (($tmpLen > 20) ? '...' : '');
    }

    /**
     * 处理评论审核的业务
     */
    public function approve()
    {
        $this->status = 2; //设置评论状态为已审核
        return ($this->save() ? true : false);
    }

    /**
     * 气泡通知
     * @return mixed
     */
    public static function getPengdingCommentCount()
    {
        return Comment::find()->where(['status' => 1])->count();
    }

    /**
     * 保存创建时间
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
            }
            return true;
        } else  return false;
    }

    /**
     *评论审核状态下拉菜单
     */
    public function getApproves(){
        return Commentstatus::getApprove();
    }
}
