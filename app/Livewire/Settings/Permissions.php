<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    public $name;
    public $permissionId;
    public $showForm = false;
    public $permissions = [];

    protected $rules = [
        'name' => 'required|string|unique:permissions,name',
    ];

    public function mount()
    {
        $this->loadPermissions();
    }

    public function loadPermissions()
    {
        $this->permissions = Permission::all();
    }

    public function createPermission()
    {
        $this->reset(['name', 'permissionId']);
        $this->showForm = true;
    }

    public function storePermission()
    {
        $this->validate();
        Permission::create(['name' => $this->name]);

        session()->flash('message', 'Разрешение создано.');
        $this->loadPermissions();
        $this->showForm = false;
    }

    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->showForm = true;
    }

    public function updatePermission()
    {
        $this->validate([
            'name' => 'required|string|unique:permissions,name,' . $this->permissionId,
        ]);

        Permission::where('id', $this->permissionId)->update(['name' => $this->name]);

        session()->flash('message', 'Разрешение обновлено.');
        $this->loadPermissions();
        $this->showForm = false;
    }

    public function deletePermission($id)
    {
        Permission::findOrFail($id)->delete();
        session()->flash('message', 'Разрешение удалено.');
        $this->loadPermissions();
    }

    public function render()
    {
        return view('livewire.settings.permissions', [
            'permissions' => $this->permissions, // Передаем в Blade-шаблон
        ]);
    }
}
