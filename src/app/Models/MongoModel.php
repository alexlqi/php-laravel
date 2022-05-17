<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class MongoModel extends Model
{
    //use HasFactory;

    /** @var string Mongo Connection Name */
    protected $connection='mongodb';
    protected $guarded=[];
}
