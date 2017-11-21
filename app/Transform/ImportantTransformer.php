<?php
/**
 * Created by PhpStorm.
 * User: zhangmin
 * Date: 2017/11/27
 * Time: 17:59
 */

namespace App\Transform;

class ImportantTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'title' => $item['title'],
            'body' => \MarkdownEditor::parse($item['body']),
            'created_at' => $item['created_at'],
            'is_important' => $item['is_important'],
            'tags' => $item['tags'],
            'category' => $item['category']
        ];
    }
}