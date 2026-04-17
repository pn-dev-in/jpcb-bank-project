<?php

function log_activity($admin_id, $action, $module, $record_id = null)
{
    $db = \Config\Database::connect();

    $db->table('activity_logs')->insert([
        'admin_id' => $admin_id,
        'action' => $action,
        'module' => $module,
        'record_id' => $record_id,
        'created_at' => date('Y-m-d H:i:s')
    ]);
}