<?php

namespace app\models;


use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    const TYPE_ENTRY = 'entry';
    const TYPE_CATEGORY = 'category';

    /**
     * Prepare data for frontend controller
     * @return array
     */
    public static function getPreparedJsonEntries()
    {
        $entries = Entry::find()->orderBy('name')->asArray()->all();
        $categories = Category::find()->orderBy('name')->asArray()->all();

        // Sort entries
        $sortedEntries = [];
        foreach ($entries as $k=>$e) {
            $e['type'] = self::TYPE_ENTRY;
            $sortedEntries[$e['category']][] = $e;
        }

        return static::recursiveTree($categories, $sortedEntries);
    }

    /**
     * Recursive method to build tree structure
     * @param array $elements
     * @param array $entries
     * @param int $parentId
     * @return array
     */
    private static function recursiveTree(array $elements, array $entries, $parentId = 0) {
        $new = [];
        foreach($elements as $element) {
            if($element['subcategory'] == $parentId) {
                $element['type'] = self::TYPE_CATEGORY;
                $children = self::recursiveTree($elements, $entries, $element['id']);
                $element['items'] = [];
                if($children) {
                    $element['items'] = $children;
                }
                if(isset($entries[$element['id']])) {
                    $element['items'] = array_merge($entries[$element['id']], $element['items']);
                }
                $new[] = $element;
            }
        }
        return $new;
    }
}