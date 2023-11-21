<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\ContactConsts;
use Illuminate\Support\Arr;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $primaryKey = 'id';

    protected $casts = [
        'name' => 'encrypted',
        'mail_address' => 'encrypted',
        'created_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'mail_address',
        'mail_body',
    ];


    public function insertContact(array $data)
    {
        $this->status = ContactConsts::STATUS_NOT_STARTED;
        $this->fill($data);

        $this->save();
    }


    public function getAdminLists(array $data)
    {
        $query = $this::query();

        $query->when(Arr::exists($data, 'name') && $data['name'], function ($query) use ($data) {
            return $query->where('name', 'like', "%{$data['name']}%");
        });

        $query->when(Arr::exists($data, 'mail_body') && $data['mail_body'], function ($query) use ($data) {
            return $query->where('mail_body', 'like', "%{$data['mail_body']}%");
        });

        $query->when(Arr::exists($data, 'created_at_from') && $data['created_at_from'], function ($query) use ($data) {
            return $query->where('created_at', '>=',  $data['created_at_from']);
        });

        $query->when(Arr::exists($data, 'created_at_to') && $data['created_at_to'], function ($query) use ($data) {
            return $query->where('created_at', '<=',  $data['created_at_to']);
        });

        $query->when(Arr::exists($data, 'status') && $data['status'], function ($query) use ($data) {
            return $query->whereIn('status', $data['status']);
        });

        $lists = $query->paginate(ContactConsts::PAGENATE_LIST_LIMIT);

        return $lists;
    }


    public function updateContactStatus(array $data)
    {
        $contact = $this::find($data['id']);
        $contact->status = $data['status'];
        $contact->save();
    }
}
