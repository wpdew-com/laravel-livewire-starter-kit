<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleList extends Component
{
    public $roles, $permissions;
    public $name, $selectedPermissions = [];
    public $showForm = false;
    public $roleIdToEdit = null;

    public function mount()
    {
        $this->roles = Role::with('permissions')->get();
        $this->permissions = Permission::all();
    }

    public function createRole()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function editRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $this->roleIdToEdit = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->showForm = true;
    }

    public function storeRole()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleIdToEdit,
            'selectedPermissions' => 'array'
        ]);

        $role = $this->roleIdToEdit ? Role::findOrFail($this->roleIdToEdit) : new Role();
        $role->name = $this->name;
        $role->save();
        $role->syncPermissions($this->selectedPermissions);

        session()->flash('message', $this->roleIdToEdit ? __('users.Role updated') : __('users.Role created'));
        $this->resetForm();
        $this->showForm = false;
        $this->mount();
    }

    public function deleteRole($roleId)
    {
        Role::findOrFail($roleId)->delete();
        session()->flash('message', __('users.Role deleted'));
        $this->mount();
    }

    private function resetForm()
    {
        $this->roleIdToEdit = null;
        $this->name = '';
        $this->selectedPermissions = [];
    }

    public function render()
    {
        return view('livewire.settings.role-list');
    }
}
