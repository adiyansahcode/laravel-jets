<?php

declare(strict_types=1);

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class Index extends Component
{
    /**
     * title page
     */
    public string $title;

    /**
     * user role
     */
    public array $roles;

    /**
     * form variable
     *
     */
    public $dataId;
    public $name;
    public $email;
    public $password;
    public $roleId;
    public $role;

    /**
     * modal status
     */
    public bool $createModal = false;
    public bool $updateModal = false;

    protected $listeners = [
        'userEdit' => 'edit',
        'userDelete' => 'delete',
    ];

    public function mount()
    {
        $this->title = 'Users List';
        $this->roles = Role::pluck('title', 'id')->toArray();
    }

    public function render()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('livewire.users.index')
            ->layoutData(['title' =>  $this->title]);
    }

    /**
     * Open the modal
     *
     * @var array
     */
    public function openCreateModal()
    {
        $this->createModal = true;
    }

    /**
     * Open the modal
     *
     * @var array
     */
    public function openUpdateModal()
    {
        $this->updateModal = true;
    }

    /**
     * Close the modal
     *
     * @var array
     */
    public function closeModal()
    {
        $this->createModal = false;
        $this->updateModal = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
    }

    /**
     * Open the modal when create
     *
     * @var array
     */
    public function create()
    {
        $this->resetValidation();
        $this->resetInputFields();
        $this->openCreateModal();
    }

    /**
     * Validate then Insert data
     *
     * @return void
     */
    public function store()
    {
        $this->validate([
            'name' => [
                'string',
                'required',
            ],
            'email'    => [
                'required',
                'email:rfc,dns',
                'unique:App\Models\User,email',
            ],
            'password' => [
                'required',
                'alpha_num',
                'min:5',
                'max:10',
            ],
            'role' => [
                'required',
                'integer',
            ],
        ]);

        $user = User::Create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => app('hash')->make($this->password),
        ]);

        $user->roles()->sync($this->role, []);

        session()->flash('message', 'User Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
        $this->emit('userRefresh');
    }

    /**
     * Open the modal when edit
     *
     * @var array
     */
    public function edit($id)
    {
        $this->resetValidation();
        $this->resetInputFields();

        $data = User::findOrFail($id);
        $this->dataId = $data->id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->roleId = ($data->roles()->first()) ? ($data->roles()->first()->id) : null;
        $this->role = ($data->roles()->first()) ? ($data->roles()->first()->id) : null;

        $this->openUpdateModal();
    }

    /**
     * Validate then Update data
     *
     * @return void
     */
    public function update()
    {
        $this->validate([
            'name' => [
                'string',
                'required',
            ],
            'email'    => [
                'required',
                'email:rfc,dns',
                'unique:App\Models\User,email,' . $this->dataId,
            ],
            'role' => [
                'required',
                'integer',
            ],
        ]);

        $user = User::find($this->dataId);

        $update = $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $user->roles()->sync($this->role);

        session()->flash('message', 'User Updated Successfully.');

        $this->closeModal();
        $this->resetInputFields();
        $this->emit('userRefresh');
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User Deleted Successfully.');
        $this->emit('userRefresh');
    }
}
