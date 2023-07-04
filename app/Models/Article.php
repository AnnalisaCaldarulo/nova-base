<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'subtitle', 'body', 'user_id'
    ];
    protected $casts = [
        'published_at'=>'datetime',
        'meta'=>'array'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
