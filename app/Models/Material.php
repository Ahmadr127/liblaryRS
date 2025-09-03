<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'organizer',
        'source',
        'activity_date',
        'uploaded_by',
    ];

    protected $casts = [
        'activity_date' => 'date',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(MaterialFile::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return $this->category?->display_name ?? 'Unknown';
    }

    public function getMainFileAttribute()
    {
        return $this->files()->first();
    }

    public function getFileCountAttribute()
    {
        return $this->files()->count();
    }
}
