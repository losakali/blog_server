<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BlogType
 *
 * @property int $type_id 类型id
 * @property string $type_name 类型名称
 * @method static \Illuminate\Database\Eloquent\Builder|BlogType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogType query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogType whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogType whereTypeName($value)
 * @mixin \Eloquent
 */
class BlogType extends Model
{
    //    定义当前模型关联的数据表
    protected  $table = 'blog_type';
//    允许批量赋值
    protected $fillable = ['type_id','type_name'];
//    定义本地作用域方法
//   public function getBlogType($query){
//       $query->
//   }
}
