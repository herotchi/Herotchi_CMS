<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstCategory extends Model
{
    use HasFactory;

    protected $table = 'first_categories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];


    public function insertFirstCategory(array $data)
    {
        $this->fill($data);

        $this->save();
    }
}
