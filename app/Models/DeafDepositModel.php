<?php

namespace App\Models;

use CodeIgniter\Model;

class DeafDepositModel extends Model
{
    protected $table = 'deaf_deposits';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'sr_no', 'udrn', 'name', 'address', 'sort_order', 'status'
    ];
    protected $useTimestamps = true;

    
    /**
     * Get paginated active deposits
     */
    public function getPaginated($perPage = 20)
    {
        return $this->where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->paginate($perPage);
    }

    /**
     * Get total count of active deposits
     */
    public function getTotalCount()
    {
        return $this->where('status', 1)->countAllResults();
    }


    /**
     * Check if UDRN already exists
     */
    public function udrnExists($udrn, $excludeId = null)
    {
        $query = $this->where('udrn', $udrn);
        if ($excludeId) {
            $query->where('id !=', $excludeId);
        }
        return $query->countAllResults() > 0;
    }
    
    /**
     * Get all existing UDRNs
     */
    public function getAllUdrns()
    {
        return $this->select('udrn')->findAll();
    }

    /**
 * Batch insert using manual INSERT syntax (works on all MySQL versions)
 */
public function insertBatchManual(array $data, int $batchSize = 500)
{
    if (empty($data)) {
        return 0;
    }
    
    $inserted = 0;
    $chunks = array_chunk($data, $batchSize);
    $db = \Config\Database::connect();
    
    foreach ($chunks as $chunk) {
        $values = [];
        foreach ($chunk as $row) {
            $values[] = "(" . 
                $db->escape($row['sr_no']) . ", " .
                $db->escape($row['udrn']) . ", " .
                $db->escape($row['name']) . ", " .
                $db->escape($row['address']) . ", " .
                $db->escape($row['sort_order'] ?? 0) . ", " .
                $db->escape($row['status'] ?? 1) .
            ")";
        }
        
        $sql = "INSERT INTO {$this->table} (sr_no, udrn, name, address, sort_order, status) 
                VALUES " . implode(', ', $values);
        
        try {
            if ($db->query($sql)) {
                $inserted += count($chunk);
            }
        } catch (\Exception $e) {
            log_message('error', 'Batch insert failed: ' . $e->getMessage());
            continue;
        }
    }
    
    return $inserted;
}
    
}