<?php

function log_activity(string $action, string $module, ?int $record_id = null): void
{
    $admin_id = session()->get('admin_id');
    if (!$admin_id) return;

    $db = \Config\Database::connect();
    $db->table('activity_logs')->insert([
        'admin_id'   => $admin_id,
        'action'     => $action,
        'module'     => $module,
        'record_id'  => $record_id,
        'ip_address' => service('request')->getIPAddress(),
        'created_at' => date('Y-m-d H:i:s')
    ]);
}