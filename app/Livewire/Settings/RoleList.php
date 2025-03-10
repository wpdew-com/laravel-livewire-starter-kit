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
    public $roleIdToDelete = null;
    public $deleteError = null;

    public function mount()
    {
        $this->loadData();
    }

    private function loadData()
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
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray(); // 🟢 Берем ID разрешений
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

        $permissionNames = Permission::whereIn('id', $this->selectedPermissions)->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        session()->flash('message', $this->roleIdToEdit ? __('users.Role updated') : __('users.Role created'));
        $this->resetForm();
        $this->showForm = false;
        $this->loadData();
    }

    public function confirmDelete($roleId)
    {
        if ($roleId == 1) {
            $this->deleteError = __('users.Cannot delete this role');
            session()->flash('message', $this->deleteError);
        } else {
            $this->roleIdToDelete = $roleId;
            $this->deleteError = null;
        }
    }

    public function deleteRole()
    {
        if ($this->roleIdToDelete && $this->roleIdToDelete != 1) {
            Role::findOrFail($this->roleIdToDelete)->delete();
            session()->flash('message', __('users.Role deleted'));
            $this->loadData();
        }
        $this->roleIdToDelete = null;
    }

    private function resetForm()
    {
        $this->roleIdToEdit = null;
        $this->name = '';
        $this->selectedPermissions = [];
        $this->deleteError = null;
    }

    public function render()
    {
        return view('livewire.settings.role-list');
    }
}
