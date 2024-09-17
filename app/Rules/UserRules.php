<?php

namespace App\Rules;

use App\Models\CombinedModel;
use Config\Database;

class UserRules
{

    // CONCEPT: Validate data using database (UNFINISHED)
    public function user_group_exists(string $str, ?string &$error = null): bool
    {
        $db = Database::connect();
        $group = $db->table('auth_groups_users')
            ->select('auth_groups_users.*')
            ->where('group', $str)
            ->countAllResults();

        $error = "Group count: " . $group; // Show error
        return false;

        $model = new CombinedModel();
        $group = $model->isAuthGroupUserExists($str);

        // If the group does not exist, return false to trigger validation error
        if ($group === false) {
            // Setting the custom error message directly in the validation system
            $error = lang('Admin.username');
            return false;
        }

        return $group;
    }
    private function setValidationError($field)
    {
        // Ensure this method is globally accessible to set the validation error
        // You may need to adapt this part based on your specific implementation.
        $validation = \Config\Services::validation();
        $validation->setError($field, lang('Admin.group_not_found'));
    }
}
