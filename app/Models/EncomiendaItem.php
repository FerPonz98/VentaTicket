<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EncomiendaItem extends Model
{
    use HasFactory;

    protected $table = 'encomienda_items';

    protected $fillable = [
        'encomienda_id',
        'cantidad',
        'descripcion',
        'peso',
        'costo',
    ];

    protected $casts = [
        'peso'  => 'decimal:2',
        'costo' => 'decimal:2',
    ];

    public function encomienda(): BelongsTo
    {
        return $this->belongsTo(Encomienda::class);
    }
}
