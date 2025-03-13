<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class Permissions extends Component
{
    public string $name = '';
    public ?int $permissionId = null;
    public bool $showForm = false;

    #[Computed]
    public function permissions()
    {
        return Permission::paginate(10);
    }

    public function createPermission()
    {
        $this->reset(['name', 'permissionId']);
        $this->showForm = true;
    }

    public function storePermission()
    {
        $this->validate(['name' => 'required|string|unique:permissions,name']);
        Permission::create(['name' => $this->name]);

        session()->flash('message', __('users.Permission created.'));
        $this->showForm = false;
    }

    public function editPermission(int $id)
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->showForm = true;
    }

    public function updatePermission()
    {
        $this->validate(['name' => 'required|string|unique:permissions,name,' . $this->permissionId]);
        Permission::where('id', $this->permissionId)->update(['name' => $this->name]);

        session()->flash('message', __('users.Permission updated.'));
        $this->showForm = false;
    }

    public function deletePermission(int $id)
    {
        Permission::findOrFail($id)->delete();
        session()->flash('message', __('users.Permission deleted.'));
    }
}
