<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SectionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    /**
     * Get all sections for this category
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'category_id');
    }
}
