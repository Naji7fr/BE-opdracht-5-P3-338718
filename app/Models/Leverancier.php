<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'Leverancier';
    
    protected $fillable = [
        'Naam',
        'ContactPersoon',
        'LeverancierNummer',
        'Mobiel',
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
        return $this->belongsToMany(Product::class, 'ProductPerLeverancier', 'LeverancierId', 'ProductId')
            ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering')
            ->withTimestamps();
    }

    public function productLeveringen()
    {
        return $this->hasMany(ProductPerLeverancier::class, 'LeverancierId');
    }
}
