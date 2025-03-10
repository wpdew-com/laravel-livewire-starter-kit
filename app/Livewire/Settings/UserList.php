<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserList extends Component
{

    public $userId, $name, $email, $password, $role, $showForm = false;
    public $editMode = false;
    public $showConfirm = false;
    public $userIdToDelete = null;
    public $locale;
    public $locales = ['en', 'ru',  'ua'];


    public function createUser()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showForm = true;
    }

    public function editUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->locale = $user->locale;
        $this->editMode = true;
        $this->showForm = true;
    }

    public function storeUser()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $this->userId,
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'locale' => 'required',
            'role' => 'required',
        ]);

        if ($this->editMode) {
            $user = User::find($this->userId);
            if (!$user) {
                session()->flash('error', __('users.User not found'));
                return;
            }

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'locale' => $this->locale,
            ]);

            if (!empty($this->password)) {
                $user->update(['password' => Hash::make($this->password)]);
            }

            session()->flash('messageok', __('users.User updated successfully'));
        } else {
            $validated['password'] = Hash::make($this->password);
            foreach ($this->locales as $locale) {
                User::create(array_merge($validated, ['locale' => $locale]));
            }
            User::create($validated);
            session()->flash('messageok', __('users.User created successfully'));
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->locale = '';
        $this->role = '';
        $this->editMode = false;
    }


    public function confirmDelete($userId)
    {
        $this->userIdToDelete = $userId;
        $this->showConfirm = true;
    }


    public function deleteUser()
    {
        if (!$this->userIdToDelete) {
            session()->flash('error', __('users.User not found'));
            return;
        }

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
        return view('livewire.settings.user-list', [
            'users' => User::with('roles')->get(),
            'roles' => Role::all(),
            'locales' => $this->locales
        ]);

    }
}
