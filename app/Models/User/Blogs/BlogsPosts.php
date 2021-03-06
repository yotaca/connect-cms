<?php

namespace App\Models\User\Blogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Userable;

class BlogsPosts extends Model
{
    // 論理削除
    use SoftDeletes;

    // 保存時のユーザー関連データの保持
    use Userable;

    // 日付型の場合、$dates にカラムを指定しておく。
    protected $dates = ['posted_at'];

    // 更新する項目の定義
    protected $fillable = ['contents_id', 'blogs_id', 'post_title', 'post_text', 'post_text2', 'categories_id', 'important', 'status', 'posted_at'];
}
