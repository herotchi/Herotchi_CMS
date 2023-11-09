<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Consts\ProductConsts;
use Illuminate\Support\Arr;

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


    public function first_category(): BelongsTo
    {
        return $this->belongsTo(FirstCategory::class);
    }


    public function second_category(): BelongsTo
    {
        return $this->belongsTo(SecondCategory::class);
    }


    public function insertProduct(array $data, string $fileName, string $dir)
    {
        $this->image = 'storage/' . $dir . '/' . $fileName;
        $this->fill($data);

        $this->save();

        return $this->id;
    }


    public function getAdminLists(array $data)
    {
        $query = $this::query();

        $query->when(Arr::exists($data, 'first_category_id') && $data['first_category_id'], function ($query) use ($data) {
            return $query->where('first_category_id', $data['first_category_id']);
        });

        $query->when(Arr::exists($data, 'second_category_id') && $data['second_category_id'], function ($query) use ($data) {
            return $query->where('second_category_id', $data['second_category_id']);
        });

        $query->when(Arr::exists($data, 'name') && $data['name'], function ($query) use ($data) {
            return $query->where('name', 'like', "%{$data['name']}%");
        });

        $query->when(Arr::exists($data, 'release_flg') && $data['release_flg'], function ($query) use ($data) {
            return $query->whereIn('release_flg', $data['release_flg']);
        });

        $lists = $query->paginate(ProductConsts::PAGENATE_LIST_LIMIT);

        return $lists;
    }
}
