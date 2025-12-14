<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPerLeverancier extends Model
{
    protected $table = 'ProductPerLeverancier';
    
    protected $fillable = [
        'LeverancierId',
        'ProductId',
        'DatumLevering',
        'Aantal',
        'DatumEerstVolgendeLevering',
        'IsActief',
        'Opmerking'
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumLevering' => 'date',
        'DatumEerstVolgendeLevering' => 'date',
        'Aantal' => 'integer',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime'
    ];

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    public function leverancier()
    {
        return $this->belongsTo(Leverancier::class, 'LeverancierId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId');
    }
}
