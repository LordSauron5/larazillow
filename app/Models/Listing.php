<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;

class Listing extends Model
{
    use HasFactory;
    
    protected $fillable = ['beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'];
    
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'by_user_id');
    }
}
