<?php

namespace App\Models;

use CodeIgniter\Model;

class CombinedModel extends Model
{
    protected $table = 'users'; // Use users table as the primary table
    protected $primaryKey = 'id';

    // Define relationships
    protected $authIdentitiesTable = 'auth_identities';

    public function getById($id)
    {
        $this->select('users.*, auth_groups_users.group, auth_identities.id as auth_identity_id, auth_identities.type, auth_identities.name, auth_identities.secret, auth_identities.secret2, auth_identities.expires, auth_identities.extra, auth_identities.force_reset, auth_identities.last_used_at')
            ->join('auth_identities', 'auth_identities.user_id = users.id')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id');

        $this->where('users.id', $id);

        return $this->first();
    }

    public function getAllUsersWithAuthIdentities($group = null)
    {
        $this->select('users.*, auth_groups_users.group, auth_identities.id as auth_identity_id, auth_identities.type, auth_identities.name, auth_identities.secret, auth_identities.secret2, auth_identities.expires, auth_identities.extra, auth_identities.force_reset, auth_identities.last_used_at')
            ->join('auth_identities', 'auth_identities.user_id = users.id')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id');

        if ($group) {
            $this->where('auth_groups_users.group', $group);
        }

        return $this->findAll();
        // return $this->select('users.*, auth_groups_users.group, auth_identities.id as auth_identity_id, auth_identities.type, auth_identities.name, auth_identities.secret, auth_identities.secret2, auth_identities.expires, auth_identities.extra, auth_identities.force_reset, auth_identities.last_used_at')
        //     ->join('auth_identities', 'auth_identities.user_id = users.id')
        //     ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
        //     ->where('auth_groups_users.group', $group)
        //     ->findAll();
    }

    public function updateUser($userId, $userData)
    {
        return $this->db->table('users')->update($userData, ['id' => $userId]);
    }

    public function updateAuthIdentity($userId, $authIdentityData)
    {
        return $this->db->table('auth_identities')->update($authIdentityData, ['user_id' => $userId]);
    }

    public function updateAuthGroups($userId, $authGroupsData)
    {
        return $this->db->table('auth_groups_users')->update($authGroupsData, ['user_id' => $userId]);
    }

    public function insertUser($data)
    {
        // Insert data into users table
        $this->db->table('users')->insert($data);
        return $this->db->insertID(); // Get the last inserted ID
    }

    public function insertAuthIdentity($data)
    {
        // Insert data into auth_identities table
        $this->db->table('auth_identities')->insert($data);
    }

    public function insertAuthGroups($data)
    {
        // Insert data into auth_groups table
        $this->db->table('auth_groups')->insert($data);
    }

    public function isAuthGroupUserExists($authGroupUser)
    {
        return ($this->db->table('auth_groups_users')
            ->select('*')
            ->where('group', $authGroupUser)
            ->countAllResults() > 0);
    }
}
