<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\FirstCategoryConsts;
use Illuminate\Support\Arr;

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


    public function getAdminList(array $data)
    {
        $query = $this::query();

        $query->when(Arr::exists($data, 'name') && $data['name'], function ($query) use ($data) {
            return $query->where('name', 'like', "%{$data['name']}%");
        });

        $lists = $query->paginate(FirstCategoryConsts::PAGENATE_LIST_LIMIT);

        return $lists;
    }
}