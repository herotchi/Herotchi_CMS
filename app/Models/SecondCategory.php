<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondCategory extends Model
{
    use HasFactory;

    protected $table = 'second_categories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'first_category_id',
        'name',
    ];


    public function insertSecondCategory(array $data)
    {
        $this->fill($data);

        $this->save();
    }
}
