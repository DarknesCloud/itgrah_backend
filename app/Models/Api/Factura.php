<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        "cliente",
        "tipo_factura",
        "producto",
        "cantidad",
        "subtotal",
        "total",
    ] ;
}