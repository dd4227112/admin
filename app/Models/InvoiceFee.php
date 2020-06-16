<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceFee extends Model {

    /**
     * Generated
     */

    protected $table = 'invoice_fees';
    protected $fillable = ['id', 'invoice_id', 'amount', 'status', 'note', 'item_name', 'project_id','quantity','unit_price','refer_expense_id'];


    public function project() {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'id');
    }

    public function invoice() {
        return $this->belongsTo(\App\Models\Invoice::class, 'invoice_id', 'id');
    }

    public function payments() {
        return $this->belongsToMany(\App\Models\Payment::class, 'invoice_fees_payments', 'invoice_fee_id', 'payment_id');
    }

    public function invoiceFeesPayments() {
        return $this->hasMany(\App\Models\InvoiceFeesPayment::class, 'invoice_fee_id', 'id');
    }


}
