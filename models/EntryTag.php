<?php

namespace app\models;


use yii\base\Exception;
use yii\db\ActiveRecord;

class EntryTag extends ActiveRecord
{
    public function getTags()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    public static function setTags($entryId, $tags)
    {
        if(!$tags) return;
        // Write new tags to Tag table
        try {
            foreach ($tags as $k=>$t) {
                // Add new tag if id is not exist
                if(!isset($t['id'])) {
                    $tag = new Tag();
                    $tag->text = $t['text'];
                    $tag->save();
                    $tags[$k]['id'] = $tag->id;
                }
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }

        // Update tags for current entry
        //TODO: rewrite with junction table relations
        try {
            EntryTag::deleteAll(['entry_id' => (int)$entryId]);
            foreach ($tags as $t) {
                $e = new EntryTag();
                $e->tag_id = $t['id'];
                $e->entry_id = $entryId;
                $e->save();
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
}

class EntryTagException extends Exception {}