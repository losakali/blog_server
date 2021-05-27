<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Blog
 *
 * @property int $blog_id 博客id
 * @property string $blog_title 博客标题
 * @property string $blog_content 博客内容
 * @property int|null $userid 创建人id
 * @property int|null $type_id 类型id
 * @property int $blog_status 博客状态 1为发布 0为草稿
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property string|null $cover_image 封面图片
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereBlogContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereBlogStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereBlogTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUserid($value)
 * @mixin \Eloquent
 */
class Blog extends Model
{
    //    定义当前模型关联的数据表
    protected  $table = 'blog';
//    禁用时间的自动更新(即禁用模型管理这两个插入时间和修改时间字段)
    public $timestamps = false;
//    允许批量赋值
    protected $fillable = ['blog_title ','blog_content','userid','type_id','cover_image'];
}
