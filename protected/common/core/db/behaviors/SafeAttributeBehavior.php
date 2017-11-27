<?php
/**
 * @category SafeAttributeBehavior
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/20 00:22
 * @since
 */
namespace common\core\db\behaviors;

use yii\base\Event;
use yii\db\ActiveRecord;

/**
 * Class SafeAttributeBehavior
 * @package common\core\db\behaviors
 */
trait SafeAttributeBehavior
{
    /**
     * Evaluates the attribute value and assigns it to the current attributes.
     * @param Event $event
     */
    public function evaluateAttributes($event)
    {
        if($this->skipUpdateOnClean && $event->name == ActiveRecord::EVENT_BEFORE_UPDATE && empty($this->owner->dirtyAttributes)){
            return;
        }

        if(!empty($this->attributes[$event->name])){
            $attributes = (array) $this->attributes[$event->name];
            $value = $this->getValue($event);
            foreach($attributes as $attribute){
                // ignore attribute names which are not string (e.g. when set by TimestampBehavior::updatedAtAttribute)
                if(is_string($attribute) && $event->sender->hasAttribute($attribute)){
                    $this->owner->$attribute = $value;
                }
            }
        }
    }
}
