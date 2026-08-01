<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanProductDocumentModel extends Model
{
    protected $table = 'loan_product_documents';
    protected $primaryKey = 'id';
    protected $allowedFields = ['loan_product_id', 'document', 'sort_order'];
    protected $useTimestamps = false;
}