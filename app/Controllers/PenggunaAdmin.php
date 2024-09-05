<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\CombinedModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\GroupModel;

use function App\Helpers\format_tanggal;

class PenggunaAdmin extends BaseControllerAdmin
{
    private string $indexRoute;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->indexRoute = base_url("/admin/pengguna");
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.pengguna');
        $combinedModel = new CombinedModel();
        $this->data['users_with_auth_identities'] = $combinedModel->getAllUsersWithAuthIdentities();

        $this->data['auth_groups'] = config('AuthGroups')->groups;
        return view('admin_users', $this->data);
    }

    public function get($group = null)
    {
        $combinedModel = new CombinedModel();

        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($combinedModel->getAllUsersWithAuthIdentities($group))
        ]));
    }

    public function keluar()
    {
        auth()->logout();

        return redirect()->to('/');
    }

    public function tambahPengguna()
    {
        $data = $this->request->getPost();

        $groupModel = new GroupModel();

        $users = auth()->getProvider();

        $user = new User([
            'username' => $data['username'],
            'email'    => $data['secret'],
            'password' => $data['secret2'],
        ]);
        $users->save($user);

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Get ID
        $id = $user->id;

        $groupModel->save(
            [
                'user_id' => $id,
                'group' => $data['group'],
                'created_at' => Time::now('Asia/Jakarta', 'en_US'), // Set the timezone to Indonesian Time (WIB)
            ]
        );

        // Add to default group
        // $users->addToDefaultGroup($user);

        return redirect()->to($this->indexRoute);
    }

    public function edit($userId)
    {
        $combinedModel = new CombinedModel();
        $data = $this->request->getPost();

        // Prepare data for users table
        $userData = [];
        if (!empty($data['username'])) {
            $userData['username'] = $data['username'];
        }
        if (!empty($data['status'])) {
            $userData['status'] = $data['status'];
        }
        if (!empty($data['status_message'])) {
            $userData['status_message'] = $data['status_message'];
        }
        $userData['active'] = isset($data['active']) ? 1 : 0; // Convert checkbox to integer
        if (!empty($data['last_active'])) {
            $userData['last_active'] = $data['last_active'];
        }

        // Prepare data for auth_identities table
        $authIdentityData = [];
        if (!empty($data['type'])) {
            $authIdentityData['type'] = $data['type'];
        }
        if (!empty($data['name'])) {
            $authIdentityData['name'] = $data['name'];
        }
        if (!empty($data['secret'])) {
            $authIdentityData['secret'] = $data['secret'];
        }
        if (!empty($data['secret2'])) {
            $authIdentityData['secret2'] = password_hash($data['secret2'], PASSWORD_BCRYPT);
        }
        if (!empty($data['expires'])) {
            $authIdentityData['expires'] = $data['expires'];
        }
        if (!empty($data['extra'])) {
            $authIdentityData['extra'] = $data['extra'];
        }

        $authIdentityData['force_reset'] = isset($data['force_reset']) ? 1 : 0; // Convert checkbox to integer

        if (!empty($data['last_used_at'])) {
            $authIdentityData['last_used_at'] = $data['last_used_at'];
        }

        // Prepare data for auth groups
        $authGroupsData = [];
        if (!empty($data['group'])) {
            $authGroupsData['group'] = $data['group'];
        }

        // Only update if there's data to update
        if (!empty($userData)) {
            $combinedModel->updateUser($userId, $userData);
        }
        if (!empty($authIdentityData)) {
            $combinedModel->updateAuthIdentity($userId, $authIdentityData);
        }
        if (!empty($authGroupsData)) {
            $combinedModel->updateAuthGroups($userId, $authGroupsData);
        }


        return redirect()->to($this->indexRoute);
    }

    public function hapusBanyak()
    {
        //
        $selectedIds = $this->request->getPost('selectedIds');

        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider();

        if (!empty($selectedIds)) {
            // Perform the deletion based on the selected IDs
            foreach ($selectedIds as $id) {
                // Add your deletion logic here Example:
                $users->delete($id, true);
            }

            // Return true indicating success
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);;
        } else {
            // Return false indicating failure
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }

        return redirect()->to($this->indexRoute);
    }
}
