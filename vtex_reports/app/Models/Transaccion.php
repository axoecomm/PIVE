<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;

    protected $table = 'vtex_transactions';

    // protected $dateFormat = 'c';

    protected $fillable = [
        'id', 
        'referenceKey', 
        'payments', 
        'totalRefunds', 
        'status', 
        'value', 
        'startDate', 
        'authorizationToken', 
        'authorizationDate', 
        'commitmentToken', 
        'commitmentDate', 
        'refundingToken', 
        'refundingDate', 
        'cancelationToken', 
        'cancelationDate', 
        'clientProfile', 
        'ipAddress', 
        'antifraudTid', 
        'merchant',
        'channel',
        'salesChannel',
        'urn',
        'softDescriptor',
        'vtexFingerprint',
        'chargeback',
        'whiteSignature',
        'buyer',
        'created_at',
        'updated_at',
    ];

}
