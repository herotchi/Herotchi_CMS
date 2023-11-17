<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

use App\Consts\NewsConsts;
use Illuminate\Support\Arr;

use DateTime;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';
    protected $primaryKey = 'id';

    protected $casts = [
        'release_date' => 'date',
    ];

    protected $fillable = [
        'title',
        'link_flg',
        'release_date',
        'release_flg'
    ];


    public function insertNews(array $data)
    {
        if ($data['link_flg'] == NewsConsts::LINK_FLG_ON) {
            $this->url = $data['url'];
        } elseif ($data['link_flg'] == NewsConsts::LINK_FLG_OFF) {
            $this->overview = $data['overview'];
        }
        $this->fill($data);

        $this->save();
    }


    public function getAdminList(array $data)
    {
        $query = $this::query();

        $query->when(Arr::exists($data, 'title') && $data['title'], function ($query) use ($data) {
            return $query->where('title', 'like', "%{$data['title']}%");
        });

        $query->when(Arr::exists($data, 'release_date_from') && $data['release_date_from'], function ($query) use ($data) {
            return $query->where('release_date', '>=',  $data['release_date_from']);
        });

        $query->when(Arr::exists($data, 'release_date_to') && $data['release_date_to'], function ($query) use ($data) {
            return $query->where('release_date', '<=',  $data['release_date_to']);
        });

        $query->when(Arr::exists($data, 'release_flg') && $data['release_flg'], function ($query) use ($data) {
            return $query->whereIn('release_flg', $data['release_flg']);
        });

        $lists = $query->paginate(NewsConsts::PAGENATE_LIST_LIMIT);

        return $lists;
    }


    public function updateNews(array $data)
    {
        $news = $this::find($data['id']);
        if ($data['link_flg'] == NewsConsts::LINK_FLG_ON) {
            $news->url = $data['url'];
            $news->overview = null;
        } elseif ($data['link_flg'] == NewsConsts::LINK_FLG_OFF) {
            $news->overview = $data['overview'];
            $news->url = null;
        }

        $news->fill($data);
        $news->save();
    }


    public function deleteNews(array $data)
    {
        $news = $this::find($data['id']);
        $news->delete();
    }


    public function saveProductNews($productId, $message)
    {
        $today = new DateTime();
        $productModel = new Product();
        $product = $productModel::find($productId);

        $this->title = $product->name . $message;
        $this->link_flg = NewsConsts::LINK_FLG_ON;
        $this->url = route('product.detail', ['id' => $productId]);
        $this->release_date = $today->format('Y-m-d');
        $this->release_flg = NewsConsts::RELEASE_FLG_OFF;

        $this->save();
    }
}
