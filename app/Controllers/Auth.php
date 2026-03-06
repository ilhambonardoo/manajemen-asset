<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController {
	public function index() {
		if (session()->get('isLoggedIn')) {
			return redirect()->to('/dashboard');
		}
		return view('auth/login');
	}

	public function register() {
		return view('auth/register');
	}

	public function registerProcess() {
		$model = new UserModel();
		$rules = $model->getValidationRules();

		if (!$this->validate($rules)) {
			return redirect()
				->back()
				->withInput()
				->with('error', $this->validator->getErrors());
		}

		$data = [
			'username' => $this->request->getPost('username'),
			'email' => $this->request->getPost('email'),
			'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
			'role_id' => 5,
			'nama_divisi' => 'General',
			'jabatan' => 'Staff',
		];

		$model->insert($data);
		return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
	}

	public function loginProcess() {
		$model = new UserModel();
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');

		$user = $model->getUserWithRole($username);

		if ($user) {
			if (password_verify($password, $user['password'])) {
				$sessionData = [
					'user_id' => $user['id'],
					'username' => $user['username'],
					'role_name' => $user['role_name'],
					'nama_divisi' => $user['nama_divisi'],
					'isLoggedIn' => true,
				];
				session()->set($sessionData);
				return redirect()->to('/dashboard');
			} else {
				return redirect()->back()->with('error', 'Username atau password salah.');
			}
		} else {
			return redirect()->back()->with('error', 'Username tidak ditemukan.');
		}
	}

	public function logout() {
		session()->destroy();
		return redirect()->to('/login');
	}
}
