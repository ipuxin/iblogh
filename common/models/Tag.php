<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
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
            'frequency' => 'Frequency',
        ];
    }

    /**
     * @param $tags
     * @return array
     * 把字符串转换为数组
     */
    public static function string2array($tags)
    {
//        return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
        return explode(',', $tags);
    }

    /**
     * @param $tags
     * @return string
     * 把数组转换为字符串
     */
    public static function array2string($tags)
    {
        return implode(',', $tags);
    }

    /**
     * @param $tags
     * 添加标签
     */
    public static function addTags($tags)
    {
        /**
         * eg:修改文章时:如果前后标签没变,则$tags为空值
         */
        if (empty($tags)) return;

        /**
         * 逐个处理传入的标签
         */
        foreach ($tags as $name) {

            /**
             * 查找标签出现的数量
             */
            $aTagCount = Tag::find()->where(['name' => $name])->count();

            /**
             * 如果没有,就新增
             */
            if (!$aTagCount) {
                $tag = new Tag;
                $tag->name = $name;
                $tag->frequency = 1;
                $tag->save();
            } else {

                /**
                 * 如果存在这个标签,就增加频率
                 */
                $aTag = Tag::find()->where(['name' => $name])->one();
                $aTag->frequency += 1;
                $aTag->save();
            }
        }
    }

    /**
     * @param $tags
     *  删除标签
     */
    public static function removeTags($tags)
    {
        if (empty($tags)) return;

        foreach ($tags as $name) {

            /**
             * 逐个查找需要删除的标签
             */
            $aTag = Tag::find()->where(['name' => $name])->one();
            $aTagCount = Tag::find()->where(['name' => $name])->count();

            if ($aTagCount) {

                /**
                 * 如果标签数量小于1,就删除这个标签
                 */
                if ($aTagCount && $aTag->frequency <= 1) {
                    $aTag->delete();
                } else {

                    /**
                     * 否则就数量减一
                     */
                    $aTag->frequency -= 1;
                    $aTag->save();
                }
            }
        }
    }

    /**
     * @param $oldTags
     * @param $newTags
     * 处理标签函数
     */
    public static function updateFrequency($oldTags, $newTags)
    {
        /**
         * 确保两个标签都不为空
         */
        if (!empty($oldTags) || !empty($newTags)) {

            /**
             * 把字符串转换为数组
             */
            $oldTagsArray = self::string2array($oldTags);
            $newTagsArray = self::string2array($newTags);

            /**
             * 利用差集函数$arr = array_diff($arr1,$arr2)
             * $arr=$arr1-$arr2
             *
             * eg:
             * $old=[1,2,3],$new=[2,3,5]
             * 新增,找到新增的标签:$new-$old=[5],执行新增
             * 删除,找到$old-$new=[1]比如修改时:新的标签
             *
             * array_values():返回数组的所有值（非键名）
             */
            self::addTags(array_values(array_diff($newTagsArray, $oldTagsArray)));
            self::removeTags(array_values(array_diff($oldTagsArray, $newTagsArray)));
        }
    }

}
