<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'file_path',
        'file_name',
        'original_name',
        'file_size',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function getFormattedSizeAttribute()
    {
        if ($this->file_size === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($this->file_size) / log($k));
        return round($this->file_size / pow($k, $i), 2) . ' ' . $sizes[$i];
    }
}
