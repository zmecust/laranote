<?php
namespace App\Transform;
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/11/28
 * Time: 12:29
 */
abstract class Transformer
{
    public function transformCollection($items) 
    {
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);
}