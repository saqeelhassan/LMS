<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'author_id',
        'status',
    ];

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    /**
     * Boot: generate slug from title when creating.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Blog $blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    /**
     * Author (user) who wrote the blog.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope: only published blogs for public listing.
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Image URL for display (storage path or placeholder).
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        return asset('dsimt-assets/images/blog/blog-1.jpg');
    }

    /**
     * Short excerpt from content for listing (first 160 chars).
     */
    public function getExcerptAttribute(): string
    {
        $text = strip_tags($this->content ?? '');
        return Str::limit($text, 160);
    }
}
