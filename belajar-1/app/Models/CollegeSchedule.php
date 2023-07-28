<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeSchedule extends Model
{
    use HasFactory;

    /*
        Eloquent will also assume that each model’s corresponding database table has a primary key column named id.
        If necessary, you may define a protected $primaryKey property on your model to specify a different column
        that serves as your model’s primary key
    */
    protected $primaryKey = 'kode';

    /*
        In addition, Eloquent assumes that the primary key is an incrementing integer value, which means that Eloquent
        will automatically cast the primary key to an integer. If you wish to use a non-incrementing or a non-numeric
        primary key you must define a public $incrementing property on your model that is set to false
    */
    public $incrementing = false;

    /*
        If your model’s primary key is not an integer, you should define a protected $keyType property on your model.
        This property should have a value of string
    */
    protected $keyType = 'string';

    /*
        By default, Eloquent expects created_at and updated_at columns to exist on your model’s corresponding database table.
        Eloquent will automatically set these column’s values when models are created or updated. If you do not want these
        columns to be automatically managed by Eloquent, you should define a $timestamps property on your model with a value of false
    */
    public $timestamps = false;
}
