<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\MediaConsts;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';
    protected $primaryKey = 'id';

    protected $fillable = [
        'media_flg',
        'alt',
        'url',
        'release_flg',
    ];


    public function insertMedia(array $data, string $fileName)
    {
        $this->image = 'storage/' . MediaConsts::IMAGE_FILE_DIR . '/' . $fileName;
        $this->fill($data);

        $this->save();
    }


    public function getAdminLists(array $data)
    {
        $query = $this::query();

        $query->when(Arr::exists($data, 'alt') && $data['alt'], function ($query) use ($data) {
            return $query->where('alt', 'like', "%{$data['alt']}%");
        });

        $query->when(Arr::exists($data, 'media_flg') && $data['media_flg'], function ($query) use ($data) {
            return $query->whereIn('media_flg', $data['media_flg']);
        });

        $query->when(Arr::exists($data, 'release_flg') && $data['release_flg'], function ($query) use ($data) {
            return $query->whereIn('release_flg', $data['release_flg']);
        });

        $query->orderBy('id', 'desc');

        $lists = $query->paginate(MediaConsts::PAGENATE_LIST_LIMIT);

        return $lists;
    }


    public function updateMedia(array $data, string $fileName)
    {
        $media = $this::find($data['id']);
        $previousImages = explode('/', $media->image);

        if ($fileName !== '') {
            $media->image = 'storage/' . MediaConsts::IMAGE_FILE_DIR . '/' . $fileName;
        }
        $media->fill($data);
        $media->save();

        if ($fileName !== '') {
            Storage::delete('public/' . MediaConsts::IMAGE_FILE_DIR . '/' . $previousImages[2]);
        }

        return $data['id'];
    }


    public function deleteMedia(array $data)
    {
        $media = $this::find($data['id']);
        $previousImages = explode('/', $media->image);
        $media->delete();
        Storage::delete('public/' . MediaConsts::IMAGE_FILE_DIR . '/' . $previousImages[2]);
    }


    public function getCarousels()
    {
        $query = $this::query();
        $query->where('media_flg', MediaConsts::MEDIA_FLG_CAROUSEL);
        $query->where('release_flg', MediaConsts::RELEASE_FLG_ON);
        $query->orderBy('id', 'desc');
        $lists = $query->get();

        return $lists;
    }


    public function getPickUps()
    {
        $query = $this::query();
        $query->where('media_flg', MediaConsts::MEDIA_FLG_PICKUP);
        $query->where('release_flg', MediaConsts::RELEASE_FLG_ON);
        $query->orderBy('id', 'desc');
        $lists = $query->get();

        return $lists;
    }
}
