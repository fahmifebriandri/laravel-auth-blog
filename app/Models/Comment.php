<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }
    public function getCommentsByParentId($parentId)
    {
        return self::where('parent_id', $parentId)->get();
    }
}