<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountTitleModel extends Model
{
    /*
    **
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'account_titles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_sub_group_name',
                            'account_group_id',
                            'description',
                            'opening_balance',
                            'default_value'];

    public function group(){
        return $this->belongsTo('App\account_groups','account_group_id');
    }
}
