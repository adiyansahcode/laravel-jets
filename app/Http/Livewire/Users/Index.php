<?php

declare(strict_types=1);

namespace App\Http\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class Index extends Component
{
    /**
     * title page.
     */
    public string $title = 'Users List';

    /**
     * list role.
     */
    public array $roles;

    /**
     * form variable.
     */
    public int $dataId = 0;

    public array $dataIds = [];

    public ?string $profilePhotoUrl = null;

    public ?string $name = null;

    public ?string $username = null;

    public ?string $phone = null;

    public ?string $email = null;

    public ?string $password = null;

    public ?string $dateOfBirth = null;

    public ?string $address = null;

    public int $roleId = 0;

    public ?string $roleTitle = null;

    /**
     * modal status.
     */
    public bool $createModal = false;

    public bool $updateModal = false;

    public bool $detailModal = false;

    public bool $deleteModal = false;

    /**
     * listen event.
     *
     * @var array
     */
    protected $listeners = [
        'userCreate' => 'create',
        'userUpdate' => 'edit',
        'userDetail' => 'show',
        'userDelete' => 'deleteConfirm',
        'userMultipleDelete' => 'multipleDeleteConfirm',
    ];

    /**
     * mount variable.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->roles = Role::pluck('title', 'id')->toArray();
    }

    /**
     * render view page.
     *
     * @return View
     */
    public function render(): View
    {
        abort_if(Gate::denies('userAccess'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('livewire.users.index')
            ->layoutData(['title' =>  $this->title]);
    }

    /**
     * reset input fields.
     *
     * @return void
     */
    private function resetInputFields(): void
    {
        $this->reset([
            'dataId',
            'dataIds',
            'profilePhotoUrl',
            'name',
            'username',
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

    /**
     * set input fields.
     *
     * @param int $id
     * @return void
     */
    private function setInputFields(int $id): void
    {
        $data = User::findOrFail($id);
        $this->dataId = $data->id;
        $this->profilePhotoUrl = $data->profile_photo_url;
        $this->name = $data->name;
        $this->username = $data->username;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->dateOfBirth = ($data->date_of_birth) ? (new Carbon($data->date_of_birth))->isoFormat('YYYY-MM-DD') : null;
        $this->address = $data->address;
        $this->roleId = ($data->role) ? ($data->role->id) : null;
        $this->roleTitle = ($data->role) ? ($data->role->title) : null;
    }

    /**
     * Open the modal when create.
     *
     * @var array
     */
    public function create()
    {
        abort_if(Gate::denies('userCreate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->resetInputFields();

        $this->createModal = true;
    }

    /**
     * Validate then Insert data.
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
            'username' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('App\Models\User', 'username')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'max:100',
            ],
            'email' => [
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
        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->date_of_birth = $this->dateOfBirth;
        $user->address = $this->address;
        $user->password = app('hash')->make($this->password);

        $user->role()->associate($this->roleId);

        $user->save();

        session()->flash('message', 'Saved Successfully.');

        $this->createModal = false;
        $this->resetInputFields();

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
    }

    /**
     * Open the modal when edit.
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        abort_if(Gate::denies('userUpdate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->resetInputFields();
        $this->setInputFields($id);

        $this->updateModal = true;
    }

    /**
     * Validate then Update data.
     *
     * @return void
     */
    public function update(): void
    {
        abort_if(Gate::denies('userUpdate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('App\Models\User', 'username')->ignore($this->dataId)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'max:100',
            ],
            'email'    => [
                'required',
                'string',
                'email:rfc,dns',
                Rule::unique('App\Models\User', 'email')->ignore($this->dataId)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'max:100',
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
        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->date_of_birth = $this->dateOfBirth;
        $user->address = $this->address;

        $user->role()->associate($this->roleId);

        $user->save();

        session()->flash('message', 'User Updated Successfully.');

        $this->updateModal = false;
        $this->resetInputFields();

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
    }

    /**
     * open detail user.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id): void
    {
        abort_if(Gate::denies('userDetail'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->resetInputFields();
        $this->setInputFields($id);

        $this->detailModal = true;
    }

    /**
     * open confirm message when delete.
     *
     * @param int $id
     * @return void
     */
    public function deleteConfirm(int $id): void
    {
        abort_if(Gate::denies('userDelete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->resetInputFields();
        $this->setInputFields($id);

        $this->deleteModal = true;
    }

    /**
     * open confirm message when delete.
     *
     * @param array $id
     * @return void
     */
    public function multipleDeleteConfirm(array $id): void
    {
        abort_if(Gate::denies('userDelete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->dataIds = $id;
        $this->deleteModal = true;
    }

    /**
     * delete user.
     *
     * @return void
     */
    public function delete(): void
    {
        abort_if(Gate::denies('userDelete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!empty($this->dataIds)) {
            User::whereIn('id', $this->dataIds)->delete();
        }

        if (!empty($this->dataId)) {
            User::find($this->dataId)->delete();
        }

        session()->flash('message', 'User Deleted Successfully.');

        $this->deleteModal = false;
        $this->resetInputFields();

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
        $this->emit('resetSelected');
    }
}
