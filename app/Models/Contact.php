<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\ContactConsts;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $primaryKey = 'id';

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
}
