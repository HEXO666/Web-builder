<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SectionTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'section_id',
        'scss_template',
        'thumbnail',
        'slug',
    ];

    /**
     * Get the section for this theme
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Get all variables for this theme
     */
    public function variables(): HasMany
    {
        return $this->hasMany(ThemeVariable::class, 'section_theme_id');
    }

    /**
     * Get all website sections using this theme
     */
    public function websiteSections(): HasMany
    {
        return $this->hasMany(WebsiteSection::class, 'section_theme_id');
    }
}
