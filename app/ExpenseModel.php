<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'expense_cash_voucher';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_type_id',
    						'paid_to',
                            'total_amount'];
}
