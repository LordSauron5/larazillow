<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = ['filename'];
    protected $appends = ['src'];

    // get listing associated with image
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    // get src atrribute of image
    public function getSrcAttribute() 
    {
        return asset("storage/{$this->filename}");
    }

}
