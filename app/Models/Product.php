<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Product';
    
    protected $fillable = [
        'Naam',
        'Barcode',
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

    public function magazijn()
    {
        return $this->hasOne(Magazijn::class, 'ProductId');
    }

    public function leveranciers()
    {
        return $this->belongsToMany(Leverancier::class, 'ProductPerLeverancier', 'ProductId', 'LeverancierId')
            ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering')
            ->withTimestamps();
    }

    public function allergenen()
    {
        return $this->belongsToMany(Allergeen::class, 'ProductPerAllergeen', 'ProductId', 'AllergeenId')
            ->withTimestamps();
    }
}
