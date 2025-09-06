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
        'context',
        'activity_date',
        'activity_date_start',
        'activity_date_end',
        'uploaded_by',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'activity_date_start' => 'date',
        'activity_date_end' => 'date',
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


    /**
     * Get activity date for display (prioritize range over single date)
     */
    public function getDisplayActivityDateAttribute()
    {
        if ($this->activity_date_start && $this->activity_date_end) {
            return $this->activity_date_range;
        }
        
        return $this->activity_date ? $this->activity_date->format('d M Y') : '';
    }

    /**
     * Get activity date range for display
     */
    public function getActivityDateRangeAttribute()
    {
        if ($this->activity_date_start && $this->activity_date_end) {
            if ($this->activity_date_start->format('Y-m-d') === $this->activity_date_end->format('Y-m-d')) {
                return $this->activity_date_start->format('d M Y');
            }
            return $this->activity_date_start->format('d M Y') . ' - ' . $this->activity_date_end->format('d M Y');
        }
        
        return $this->activity_date ? $this->activity_date->format('d M Y') : '';
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal kegiatan
     */
    public function scopeDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate || $endDate) {
            $query->where(function($q) use ($startDate, $endDate) {
                // Filter berdasarkan activity_date (single date)
                if ($startDate) {
                    $q->where('activity_date', '>=', $startDate);
                }
                if ($endDate) {
                    $q->where('activity_date', '<=', $endDate);
                }
                
                // Filter berdasarkan activity_date_start dan activity_date_end (date range)
                if ($startDate) {
                    $q->orWhere(function($subQ) use ($startDate) {
                        $subQ->whereNotNull('activity_date_start')
                             ->where('activity_date_end', '>=', $startDate);
                    });
                }
                if ($endDate) {
                    $q->orWhere(function($subQ) use ($endDate) {
                        $subQ->whereNotNull('activity_date_start')
                             ->where('activity_date_start', '<=', $endDate);
                    });
                }
            });
        }
        
        return $query;
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByCategory($query, $categoryId = null)
    {
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        return $query;
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search = null)
    {
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('organizer', 'like', "%{$search}%")
                  ->orWhere('source', 'like', "%{$search}%")
                  ->orWhere('context', 'like', "%{$search}%");
            });
        }
        
        return $query;
    }
}
