<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Comment
 *
 * @property int $id 评论id
 * @property string $comment_content 评论内容
 * @property int $blog_id 评论内容
 * @property string $createtime 评论时间
 * @property int $user_id 评论人ID
 * @property int|null $replyid 评论回复人ID
 * @property string $commentable_id
 * @property string $commentable_type 评论类型
 * @property int $level
 * @property string $is_hidden 屏蔽评论
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereReplyid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    //    定义当前模型关联的数据表
    protected  $table = 'comment';
//    禁用时间的自动更新(即禁用模型管理这两个插入时间和修改时间字段)
    public $timestamps = false;
//    允许批量赋值
    protected $fillable = ['comment_content','blog_id','userid','createtime','replyid','commentable_id','commentable_type','level','is_hidden'];

}
