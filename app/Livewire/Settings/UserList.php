<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserList extends Component
{

    public $name, $email, $password, $role, $showForm = false;
    public $showConfirm = false;
    public $userIdToDelete = null;

    public function createUser()
    {

        $this->resetForm();
        $this->showForm = true; // ✅ Показываем форму при нажатии кнопки

    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
    }


    public function storeUser()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);

            $user->assignRole($this->role);

            session()->flash('messageok', __('users.User successfully created'));
            $this->resetForm();
            $this->showForm = false; // Закрываем форму после успешного создания
        } catch (\Exception $e) {
            session()->flash('error', __('users.Error creating user: ') . $e->getMessage());
        }
    }


    public function confirmDelete($userId)
{
    $this->userIdToDelete = $userId; // ✅ Сохраняем ID пользователя для удаления
    $this->showConfirm = true; // ✅ Открываем модальное окно
}


    public function deleteUser()
    {
        if (!$this->userIdToDelete) {
            session()->flash('error', __('users.User not found'));
            return;
        }

        // Запрещаем удаление пользователя с ID 1
        if ($this->userIdToDelete == 1) {
            session()->flash('error', __('users.This user cannot be deleted'));
            return;
        }

        $user = User::find($this->userIdToDelete);

        if (!$user) {
            session()->flash('error', __('users.User not found'));
            return;
        }

        $user->delete();

        session()->flash('messageok', __('User delited'));

        $this->showConfirm = false;
        $this->userIdToDelete = null;
    }

    public function render()
    {
        $users = User::all();
        //dd($users[0]['name']);
        // массив пользователей
        //return view('livewire.settings.user-list', compact('users'));

        return view('livewire.settings.user-list', [
            'users' => User::with('roles')->get(),
            'roles' => Role::all(),
        ]);

    }
}
