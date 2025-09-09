<?php

namespace Kishan\AuditLog\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'model', 'model_id', 'action', 'old_values', 'new_values', 'user_id'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];
    public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

}
