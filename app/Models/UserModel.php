<?php

namespace App\Models;

use CodeIgniter\Model;

class CombinedModel extends Model
{
    protected $table = 'users'; // Use users table as the primary table
    protected $primaryKey = 'id';

    // Define relationships
    protected $authIdentitiesTable = 'auth_identities';

    public function getAllUsersWithAuthIdentities()
    {
        return $this->select('users.*, auth_identities.id as auth_identity_id, auth_identities.type, auth_identities.name, auth_identities.secret, auth_identities.secret2, auth_identities.expires, auth_identities.extra, auth_identities.force_reset, auth_identities.last_used_at')
            ->join('auth_identities', 'auth_identities.user_id = users.id')
            ->findAll();
    }

    public function updateUser($userId, $userData)
    {
        return $this->db->table('users')->update($userData, ['id' => $userId]);
    }

    public function updateAuthIdentity($userId, $authIdentityData)
    {
        return $this->db->table('auth_identities')->update($authIdentityData, ['user_id' => $userId]);
    }
}
