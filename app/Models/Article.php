<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'title',
        'date_of_publication',
        'article_text',
        'image'
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
