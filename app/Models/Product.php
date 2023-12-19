<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Consts\ProductConsts;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

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


    public function insertProduct(array $data, string $fileName)
    {
        $this->image = 'storage/' . ProductConsts::IMAGE_FILE_DIR . '/' . $fileName;
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

        $query->orderBy('id', 'desc');

        $lists = $query->paginate(ProductConsts::ADMIN_PAGENATE_LIST_LIMIT);

        return $lists;
    }


    public function updateProduct(array $data, string $fileName)
    {
        $product = $this::find($data['id']);
        $previousImages = explode('/', $product->image);

        if ($fileName !== '') {
            $product->image = 'storage/' . ProductConsts::IMAGE_FILE_DIR . '/' . $fileName;
        }
        $product->fill($data);
        $product->save();

        if ($fileName !== '') {
            Storage::delete('public/' . ProductConsts::IMAGE_FILE_DIR . '/' . $previousImages[2]);
        }

        return $data['id'];
    }


    public function deleteProduct(array $data)
    {
        $product = $this::find($data['id']);
        $previousImages = explode('/', $product->image);
        $product->delete();
        Storage::delete('public/' . ProductConsts::IMAGE_FILE_DIR . '/' . $previousImages[2]);
    }


    public function batchDeleteProduct(array $data)
    {
        foreach ($data['delete_flg'] as $id) {
            $product = $this::find($id);
            $previousImages = explode('/', $product->image);
            $product->delete();
            Storage::delete('public/' . ProductConsts::IMAGE_FILE_DIR . '/' . $previousImages[2]);
        }
    }


    public function getLists(array $data)
    {
        $query = $this::query();

        $query->when(Arr::exists($data, 'first_category_id') && $data['first_category_id'], function ($query) use ($data) {
            return $query->where('first_category_id', $data['first_category_id']);
        });

        $query->when(Arr::exists($data, 'second_category_id') && $data['second_category_id'], function ($query) use ($data) {
            return $query->where('second_category_id', $data['second_category_id']);
        });

        $query->when(Arr::exists($data, 'keyword') && $data['keyword'], function ($query) use ($data) {
            
            $keyword = $data['keyword'];
            // 全角スペースを半角スペースに変換
            $keyword = str_replace('　', ' ', $keyword);
            // 前後のスペース削除（trimの対象半角スペースのみなので半角スペースに変換後行う）
            $keyword = trim($keyword);
            // 連続する半角スペースを半角スペースひとつに変換
            $keyword = preg_replace('/\s+/', ' ', $keyword);
            $keywords = explode(' ', $keyword);

            return $query->where(function ($subQuery) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $subQuery->orWhere('name', 'like', "%{$keyword}%");
                    $subQuery->orWhere('detail', 'like', "%{$keyword}%");
                }
            });
        });

        $query->where('release_flg', ProductConsts::RELEASE_FLG_ON);

        $query->orderBy('id', 'desc');

        $lists = $query->paginate(ProductConsts::PAGENATE_LIST_LIMIT);

        return $lists;
    }


    public function getFirstCategoryIds()
    {
        return $this::where('release_flg', ProductConsts::RELEASE_FLG_ON)->orderBy('first_category_id')->pluck('first_category_id')->unique()->toArray();
    }


    public function getSecondCategoryIds()
    {
        return $this::where('release_flg', ProductConsts::RELEASE_FLG_ON)->orderBy('second_category_id')->pluck('second_category_id')->unique()->toArray();
    }
}
