<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /* QUERY DB */
    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeIsPublish($query)
    {
        $query->where('is_publish', '1');
    }

    /* FUNGSI */
    public function getPreviewContent()
    {
        return Str::limit($this->content, 150);
    }

    public function getWaktuBaca()
    {
        $mins = round(str_word_count($this->content) / 250);

        return ($mins < 1) ? 1 : $mins;
    }

    /* RELASI */
    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
