<?php

namespace App\Helpers;

if (!function_exists('update_many')) {
    function update_many(array $selectedIds, $model, array $updateData)
    {
        if (!empty($selectedIds)) {
            // Perform the update based on the selected IDs
            foreach ($selectedIds as $id) {
                // Add your update logic here
                $updateData['id'] = $id;
                $model->save($updateData);
            }

            // Return true indicating success
            return true;
        } else {
            // Return false indicating failure
            return false;
        }
    }
}


if (!function_exists('delete_many')) {
    function delete_many(array $selectedIds, $model)
    {
        if (!empty($selectedIds)) {
            // Perform the deletion based on the selected IDs
            foreach ($selectedIds as $id) {
                // Add your deletion logic here Example:
                $model->delete($id);
            }

            // Return true indicating success
            return true;
        } else {
            // Return false indicating failure
            return false;
        }
    }
}
