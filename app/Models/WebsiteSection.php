<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'section_id',
        'section_theme_id',
        'order',
        'custom_variables',
    ];

    protected $casts = [
        'custom_variables' => 'array',
    ];

    /**
     * Get the website for this section
     */
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

    /**
     * Get the section for this website section
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Get the theme for this website section
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(SectionTheme::class, 'section_theme_id');
    }
}
