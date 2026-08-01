<?php

namespace App\Models;

use CodeIgniter\Model;

class JbbUserModel extends Model
{
    protected $table = 'jbb_users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'email', 'password', 'role', 'is_active', 'last_login'];

    public function authenticate(string $email, string $password)
    {
        $user = $this->where('email', $email)->where('is_active', 1)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}