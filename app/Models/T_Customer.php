<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_Customer extends Model
{
    use HasFactory;

    //Model T_Customer merepresentasikan table T_Customer
    protected $table = 'T_Customer';

    // Isi dari table T_Customer
    protected $fillable = [
        'Kode_Customer', 'Nama_Customer'
    ];

    // Membertahu model Kode_Customer dan string = primary key, src default primary id dan int
    protected $primaryKey = 'Kode_Customer';
    protected $keyType = 'string';
    public $incrementing = false;
}
