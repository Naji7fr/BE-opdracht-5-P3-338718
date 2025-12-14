<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergeen extends Model
{
    protected $table = 'Allergeen';
    
    protected $fillable = [
        'Naam',
        'Omschrijving',
        'IsActief',
        'Opmerking'
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime'
    ];

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    public function producten()
    {
        return $this->belongsToMany(Product::class, 'ProductPerAllergeen', 'AllergeenId', 'ProductId')
            ->withTimestamps();
    }
}
