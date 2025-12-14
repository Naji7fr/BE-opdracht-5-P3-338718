<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazijn extends Model
{
    protected $table = 'Magazijn';
    
    protected $fillable = [
        'ProductId',
        'VerpakkingsEenheid',
        'AantalAanwezig',
        'IsActief',
        'Opmerking'
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'VerpakkingsEenheid' => 'decimal:1',
        'AantalAanwezig' => 'integer',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime'
    ];

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId');
    }
}
