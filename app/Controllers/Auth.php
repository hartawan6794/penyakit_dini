<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{

    public function index()
    {
        return view('login');
    }
    public function login()
    {
        $response = [];


        if ($this->request->getMethod() == 'POST') {
            // Validasi input
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]',
                'password' => 'required|min_length[6]|max_length[255]'
            ];

            if (!$this->validate($rules)) {
                $response['status'] = 'error';
                $response['messages'] = $this->validator->getErrors();
            } else {
                $model = new UserModel();
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $user = $model->where('username', $username)->first();

                if ($user && password_verify($password, $user->password)) {
                    // Simpan session user
                    session()->set([
                        'user_id' => $user->id_user,
                        'username' => $user->username,
                        'nama' => $user->nama,
                        'logged_in' => true
                    ]);
                    $response['status'] = 'success';
                } else {
                    $response['status'] = 'error';
                    $response['messages'] = 'Username atau Password salah';
                }
            }
        }

        return $this->response->setJSON($response);
    }

    public function logout()
    {
        $session = session();
        session()->setFlashdata('warning', 'Anda Berhasil Logout.');
        $session->destroy();
        // Redirect ke halaman awal
        return redirect()->to(base_url('auth'));
    }
}
