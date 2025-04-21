<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'html_template',
        'thumbnail',
        'slug',
    ];

    /**
     * Get the category for this section
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(SectionCategory::class, 'category_id');
    }

    /**
     * Get all themes for this section
     */
    public function themes(): HasMany
    {
        return $this->hasMany(SectionTheme::class, 'section_id');
    }

    /**
     * Get all website sections using this section
     */
    public function websiteSections(): HasMany
    {
        return $this->hasMany(WebsiteSection::class, 'section_id');
    }
}
