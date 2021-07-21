<?php

declare(strict_types=1);

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class Index extends Component
{
    /**
     * title page
     */
    public string $title = 'Users List';

    /**
     * list role
     */
    public array $roles;

    /**
     * form variable
     *
     */
    public int $dataId = 0;
    public ?string $profilePhotoUrl = '';
    public ?string $name = '';
    public ?string $phone = '';
    public ?string $email = '';
    public ?string $password = '';
    public ?string $dateOfBirth = '';
    public ?string $address = '';
    public int $roleId = 0;
    public ?string $roleTitle = '';

    /**
     * modal status
     */
    public bool $createModal = false;
    public bool $updateModal = false;
    public bool $detailModal = false;

    /**
     * listen event
     *
     * @var array
     */
    protected $listeners = [
        'userCreate' => 'create',
        'userUpdate' => 'edit',
        'userDelete' => 'delete',
        'userDetail' => 'show',
    ];

    public function mount()
    {
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
     * Open the modal
     *
     * @var array
     */
    public function openDetailModal()
    {
        $this->detailModal = true;
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
        $this->detailModal = false;
    }

    private function resetInputFields()
    {
        $this->reset([
            'dataId',
            'profilePhotoUrl',
            'name',
            'phone',
            'email',
            'password',
            'dateOfBirth',
            'address',
            'roleId',
            'roleTitle',
        ]);

        // These two methods do the same thing, they clear the error bag.
        $this->resetErrorBag();
        $this->resetValidation();
    }

    private function setInputFields(int $id): void
    {
        $data = User::findOrFail($id);
        $this->dataId = $data->id;
        $this->profilePhotoUrl = $data->profile_photo_url;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->dateOfBirth = ($data->date_of_birth) ? (new Carbon($data->date_of_birth))->isoFormat('YYYY-MM-DD') : null;
        $this->address = $data->address;
        $this->roleId = ($data->role) ? ($data->role->id) : null;
        $this->roleTitle = ($data->role) ? ($data->role->title) : null;
    }

    /**
     * Open the modal when create
     *
     * @var array
     */
    public function create()
    {
        abort_if(Gate::denies('userCreate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'required',
                'string',
                'max:100',
            ],
            'email'    => [
                'required',
                'email:rfc,dns',
                Rule::unique('App\Models\User', 'email')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'max:100',
            ],
            'phone' => [
                'required',
                'numeric',
                Rule::unique('App\Models\User', 'phone')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'digits_between:1,20',
            ],
            'dateOfBirth' => [
                'present',
                'date',
                'date_format:Y-m-d',
            ],
            'address' => [
                'present',
                'string',
                'max:200',
            ],
            'password' => [
                'required',
                'alpha_num',
                'min:5',
                'max:10',
            ],
            'roleId' => [
                'required',
                'integer',
                Rule::in(Role::all()->pluck('id')),
            ],
        ]);

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->date_of_birth = ($this->dateOfBirth) ? (new Carbon($this->dateOfBirth))->isoFormat('YYYY-MM-DD') : null;
        $user->address = $this->address;
        $user->password = app('hash')->make($this->password);

        $user->role()->associate($this->roleId);

        $user->save();

        session()->flash('message', $this->dateOfBirth);

        $this->closeModal();
        $this->resetInputFields();

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
    }

    /**
     * Open the modal when edit
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        abort_if(Gate::denies('userUpdate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->resetInputFields();
        $this->setInputFields($id);
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
            'phone'    => [
                'required',
                'numeric',
                Rule::unique('App\Models\User', 'phone')->ignore($this->dataId)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'digits_between:1,20',
            ],
            'dateOfBirth' => [
                'present',
                'date',
                'date_format:Y-m-d',
            ],
            'address' => [
                'present',
                'string',
                'max:200',
            ],
            'roleId' => [
                'required',
                'integer',
                Rule::in(Role::all()->pluck('id')),
            ],
        ]);

        $user = User::find($this->dataId);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->date_of_birth = ($this->dateOfBirth) ? (new Carbon($this->dateOfBirth))->isoFormat('YYYY-MM-DD') : null;
        $user->address = $this->address;

        $user->role()->associate($this->roleId);

        $user->save();

        session()->flash('message', 'User Updated Successfully.');

        $this->closeModal();
        $this->resetInputFields();

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
    }

    /**
     * open detail user
     *
     * @param int $id
     * @return void
     */
    public function show(int $id): void
    {
        abort_if(Gate::denies('userDetail'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->resetInputFields();
        $this->setInputFields($id);
        $this->openDetailModal();
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
