<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GCFinalOrderStatus extends Model
{
    protected $table = 'gc_order_statuses';

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id', 'ticket_id');
    }

    public function customerBills()
    {
        return $this->hasMany(CustomerBill::class, 'ticket_id', 'ticket_id');
    }

    public function finalOrders()
    {
        return $this->hasMany(GCFinalOrder::class, 'ticket_id', 'ticket_id');
    }
    public function finalOrdersCancel()
    {
        return $this->hasMany(GCFinalOrder::class, 'ticket_id', 'ticket_id')->where('canceled_status',0);
    }
    public function finalOrdersCancelItem()
    {
        return $this->hasMany(GCFinalOrder::class, 'ticket_id', 'ticket_id')->where('canceled_status',1);
    }

}
