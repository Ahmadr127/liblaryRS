<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'image',
        'category_id',
        'author_id',
        'status',
        'published_at',
        'views',
        'meta_data'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'meta_data' => 'array',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Accessors & Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        return Str::limit(strip_tags($this->content), 150);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Draft',
            'published' => 'Dipublikasi',
            'archived' => 'Diarsipkan',
            default => 'Tidak Diketahui'
        };
    }

    // Scopes
    public function scopePublished($query)
    {
        // Hanya tampilkan yang berstatus published dan sudah memiliki tanggal publikasi yang aktif
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now('Asia/Jakarta'));
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isPublished()
    {
        // Published jika status published dan tanggal publikasi sudah aktif
        return $this->status === 'published' &&
               $this->published_at &&
               $this->published_at <= now('Asia/Jakarta');
    }
}
