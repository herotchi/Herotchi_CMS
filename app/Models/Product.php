<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\ProductConsts;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'first_category_id',
        'second_category_id',
        'name',
        'detail',
        'release_flg',
    ];


    public function insertProduct(array $data, string $fileName, string $dir)
    {
        $this->image = 'storage/' . $dir . '/' . $fileName;
        $this->fill($data);

        $this->save();

        return $this->id;
    }
}
