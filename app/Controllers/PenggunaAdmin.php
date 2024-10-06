<?php

namespace App\Controllers;

use App\Models\AktivitasLoginModel;
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

    public function indexAktivitasLogin()
    {
        $this->data['judul'] = lang('Admin.aktivitasLogin');
        $aktivitasLoginModel = new AktivitasLoginModel();
        $this->data['user'] = $aktivitasLoginModel->getUniqueUserLogins();

        $this->data['auth_groups'] = config('AuthGroups')->groups;
        return view('admin_aktivitas_login', $this->data);
    }

    public function getDTAktivitasLogin($userId = null)
    {
        $aktivitasLoginModel = new AktivitasLoginModel();
        // $columns = ['id_jenis', 'judul', 'waktu_mulai', 'created_at', 'status']; // DEBUG id_jenis
        $columns = ['id', 'username', 'active', 'last_active', 'identifier', 'user_id', 'date', 'success'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
        if ($userId == null) $userId = $this->request->getPost('user_id');

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $aktivitasLoginModel->countAllResults(); // Count Agenda
        $totalFiltered = $totalData;

        $agenda = $aktivitasLoginModel->getDT($limit, $start, $search, $order, $dir, userId: $userId);

        if ($search || $userId) {
            $totalFiltered = $aktivitasLoginModel->getDTTotalRecords($search, userId: $userId);
        }

        $data = [];
        if (!empty($agenda)) {
            foreach ($agenda as $row) {
                $nestedData['id'] = $row->id;
                $nestedData['username'] = $row->username;
                $nestedData['identifier'] = $row->identifier;
                $nestedData['date'] = $row->date;
                $nestedData['success'] = $row->success;
                $nestedData['ip_address'] = $row->ip_address;
                $nestedData['user_id'] = $row->user_id;
                // $nestedData['status'] = $row->status;
                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($this->request->getPost('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return $this->response->setJSON($json_data);
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

    public function tambahPenggunaAjax()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            // Validation rules
            $validation->setRules([
                'username' => [
                    'label' => lang('Admin.username'),
                    'rules'   => 'required|min_length[3]|max_length[30]|is_unique[users.username]'
                ],
                'secret'   => [
                    'label' => lang('Admin.email'),
                    'rules'   => 'required|valid_email|is_unique[auth_identities.secret]'
                ],
                'secret2'  => [
                    'label' => lang('Admin.kataSandi'),
                    'rules'   => 'required|min_length[6]'
                ],
                'group'    => [
                    'label' => lang('Admin.grup'),
                    'rules'   => 'required'
                ],
            ]);

            // Validate input
            if (!$this->validate($validation->getRules())) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $validation->getErrors()
                ]);
            }

            $data = $this->request->getPost();
            $groupModel = new GroupModel();
            $users = auth()->getProvider();

            // Create user
            $user = new User([
                'username' => $data['username'],
                'email'    => $data['secret'],
                'password' => $data['secret2']
            ]);
            $users->save($user);

            // Get ID of the newly inserted user
            $user = $users->findById($users->getInsertID());
            $id = $user->id;

            // Assign to a group
            $groupModel->save([
                'user_id'    => $id,
                'group'      => $data['group'],
                'created_at' => Time::now('Asia/Jakarta', 'en_US')
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'User successfully created!'
            ]);
        }
    }

    public function editAjax()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $combinedModel = $this->combinedModel;
            $data = $this->request->getPost();
            $userId = $data['id']; // Get the user id

            $currentUser = $combinedModel->getById($userId);

            // Individual input rules
            $usernameRule = 'required|min_length[3]|max_length[30]';
            $emailRule = 'required|valid_email';

            if ($currentUser['username'] !== $data['username']) {
                $usernameRule = 'required|min_length[3]|max_length[30]|is_unique[users.username]';
            }

            if ($currentUser['secret'] !== $data['secret']) {
                $emailRule = 'required|valid_email|is_unique[auth_identities.secret]';
            }

            $validationRules = [
                'username' => [
                    'label' => lang('Admin.username'),
                    'rules'   => $usernameRule
                ],
                'secret'   => [
                    'label' => lang('Admin.email'),
                    'rules'   => $emailRule
                ],
                'group'    => [
                    'label' => lang('Admin.grup'),
                    'rules'   => 'required'
                ],
            ];

            if (!empty($data['secret2'])) {
                $validationRules = array_merge(
                    $validationRules,
                    [
                        'secret2'  => [
                            'label' => lang('Admin.kataSandi'),
                            'rules'   => 'required|min_length[6]'
                        ]
                    ]
                );
            }

            // Validation rules
            $validation->setRules($validationRules);

            // Validate input
            if (!$this->validate($validation->getRules())) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors'  => $validation->getErrors()
                ]);
            }

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

            return $this->response->setJSON([
                'success' => true,
                'message' => 'User successfully updated!'
            ]);
        }
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
