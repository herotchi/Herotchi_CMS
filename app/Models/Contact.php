<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\ContactConsts;
use Illuminate\Support\Arr;

use DateTime;

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

        $this->no = str_pad($this->id, 10, 0, STR_PAD_LEFT);
        $this->save();

        return $this->no;
    }


    public function getAdminLists(array $data)
    {
        $query = $this::query();

        $query->when(Arr::exists($data, 'no') && $data['no'], function ($query) use ($data) {
            return $query->where('no', $data['no']);
        });

        $query->when(Arr::exists($data, 'mail_body') && $data['mail_body'], function ($query) use ($data) {
            return $query->where('mail_body', 'like', "%{$data['mail_body']}%");
        });

        $query->when(Arr::exists($data, 'created_at_from') && $data['created_at_from'], function ($query) use ($data) {
            $from = new DateTime($data['created_at_from']);
            $from->setTime(0, 0, 0);
            return $query->where('created_at', '>=',  $from->format('Y-m-d H:i:s'));
        });

        $query->when(Arr::exists($data, 'created_at_to') && $data['created_at_to'], function ($query) use ($data) {
            $to = new DateTime($data['created_at_to']);
            $to->setTime(23, 59, 59);
            return $query->where('created_at', '<=', $to->format('Y-m-d H:i:s'));
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
