<?php namespace App\Models; use CodeIgniter\Model;
class UpiTransactionLimitModel extends Model {
    protected $table = 'upi_transaction_limits';
    protected $primaryKey = 'id';
    protected $allowedFields = ['transaction_type','per_transaction','per_day_limit','per_day_count','per_month_limit','per_month_count','per_month_upi','sort_order','status'];
    protected $useTimestamps = true;
}