<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
        'categories' => 'array',
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

    public function scopeWithCategory($query, $category)
    {
        $query->whereHas('categories', function($query) use ($category) {
            $query->where('slug', $category);
        });
    }

    /* FUNGSI */
    public function getThumbnailImage()
    {
        $isUrl = Str::contains($this->image, 'http');

        return ($isUrl) ? $this->image : Storage::disk('public')->url($this->image);
    }

    public function getProfilePicture()
    {
        $isUrl = Str::contains($this->penulis->profile_photo_path, 'http');

        return ($isUrl) ? $this->penulis->profile_photo_url : Storage::disk('public')->url($this->penulis->profile_photo_path);
    }

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

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
