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
    public $phone;
    public $email;
    public $password;
    public $dateOfBirth;
    public $address;
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
        abort_if(Gate::denies('userAccess'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('userCreate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('userCreate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate([
            'name' => [
                'string',
                'required',
            ],
            'email'    => [
                'required',
                'email:rfc,dns',
                Rule::unique('App\Models\User', 'email')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
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
                Rule::in(Role::all()->pluck('id')),
            ],
        ]);

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = app('hash')->make($this->password);

        $user->role()->associate($this->role);

        $user->save();

        session()->flash('message', 'User Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
    }

    /**
     * Open the modal when edit
     *
     * @var array
     */
    public function edit($id)
    {
        abort_if(Gate::denies('userUpdate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->resetValidation();
        $this->resetInputFields();

        $data = User::findOrFail($id);
        $this->dataId = $data->id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->roleId = ($data->role) ? ($data->role->id) : null;
        $this->role = ($data->role) ? ($data->role->id) : null;

        $this->openUpdateModal();
    }

    /**
     * Validate then Update data
     *
     * @return void
     */
    public function update()
    {
        abort_if(Gate::denies('userUpdate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate([
            'name' => [
                'string',
                'required',
            ],
            'email'    => [
                'required',
                'email:rfc,dns',
                Rule::unique('App\Models\User', 'email')->ignore($this->dataId)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'role' => [
                'required',
                'integer',
                Rule::in(Role::all()->pluck('id')),
            ],
        ]);

        $user = User::find($this->dataId);
        $user->name = $this->name;
        $user->email = $this->email;

        $user->role()->associate($this->role);

        $user->save();

        session()->flash('message', 'User Updated Successfully.');

        $this->closeModal();
        $this->resetInputFields();

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
    }

    public function delete($id)
    {
        abort_if(Gate::denies('userDelete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        User::find($id)->delete();

        session()->flash('message', 'User Deleted Successfully.');

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
    }
}
