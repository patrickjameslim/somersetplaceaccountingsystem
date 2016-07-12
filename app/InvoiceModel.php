<?php
/*
* @Author:      Kristopher N. Veraces
* @Description: Serves as model for Invoice in Database
* @Date:        6/27/2016
*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'home_owner_invoice';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_type_id',
    						'home_owner_id',
                            'total_amount',
                            'payment_due_date'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
