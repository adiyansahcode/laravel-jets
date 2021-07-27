<?php

declare(strict_types=1);

namespace App\Http\Livewire\Role;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Index extends Component
{
    /**
     * title layout page.
     */
    public string $titleLayout = 'Role';

    /**
     * list permissions.
     */
    public array $permissions;

    public array $permissionId = [];

    /**
     * form variable.
     */
    public int $dataId = 0;

    public array $dataIds = [];

    public ?string $title = null;

    public ?string $detail = null;

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
        'create' => 'create',
        'update' => 'edit',
        'detail' => 'show',
        'delete' => 'deleteConfirm',
        'multipleDelete' => 'multipleDeleteConfirm',
    ];

    /**
     * mount variable.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->permissions = Permission::pluck('title', 'id')->toArray();
    }

    /**
     * render view page.
     *
     * @return View
     */
    public function render(): View
    {
        abort_if(Gate::denies('roleAccess'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('livewire.role.index')
            ->layoutData(['title' =>  $this->titleLayout]);
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
            'title',
            'detail',
            'permissionId',
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
        $data = Role::findOrFail($id);
        $this->dataId = $data->id;
        $this->title = $data->title;
        $this->detail = $data->detail;

        $this->permissionId = ($data->permissions) ? ($data->permissions->pluck('id')->toArray()) : [];
    }

    public function setPermissionId(int $value)
    {
        $array = $this->permissionId;
        if (in_array($value, $array)) {
            if (($key = array_search($value, $array)) !== false) {
                unset($array[$key]);
            }
        } else {
            array_push($array, $value);
        }

        $this->permissionId = $array;
    }

    /**
     * Open the modal when create.
     *
     * @var array
     */
    public function create()
    {
        abort_if(Gate::denies('roleCreate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('roleCreate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate([
            'title' => [
                'required',
                'string',
                'max:100',
                Rule::unique('App\Models\Role', 'title')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                function ($attribute, $value, $fail) {
                    // check unique case sensitive
                    $data = Role::whereRaw('LOWER(title) = ?', [Str::lower($value)])->first();
                    if ($data) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                }
            ],
            'detail' => [
                'nullable',
                'string',
                'max:200',
            ],
        ]);

        $data = new Role();
        $data->title = $this->title;
        $data->detail = $this->detail;
        $data->save();

        $data->permissions()->sync($this->permissionId);

        session()->flash('message', 'data saved successfully.');

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
        abort_if(Gate::denies('roleUpdate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('roleUpdate'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->validate([
            'title' => [
                'required',
                'string',
                'max:100',
                Rule::unique('App\Models\Role', 'title')->ignore($this->dataId)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                function ($attribute, $value, $fail) {
                    // check unique case sensitive
                    $data = Role::where('id', '<>', $this->dataId)->whereRaw('LOWER(title) = ?', [Str::lower($value)])->first();
                    if ($data) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                }
            ],
            'detail' => [
                'nullable',
                'string',
                'max:200',
            ],
        ]);

        $data = Role::find($this->dataId);
        $data->title = $this->title;
        $data->detail = $this->detail;
        $data->save();

        $data->permissions()->sync($this->permissionId);

        session()->flash('message', 'data updated successfully.');

        $this->updateModal = false;
        $this->resetInputFields();

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
    }

    /**
     * open detail data.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id): void
    {
        abort_if(Gate::denies('roleDetail'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('roleDelete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('roleDelete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->dataIds = $id;
        $this->deleteModal = true;
    }

    /**
     * delete data.
     *
     * @return void
     */
    public function delete(): void
    {
        abort_if(Gate::denies('roleDelete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!empty($this->dataIds)) {
            Role::whereIn('id', $this->dataIds)->delete();
        }

        if (!empty($this->dataId)) {
            Role::find($this->dataId)->delete();
        }

        session()->flash('message', 'data deleted successfully.');

        $this->deleteModal = false;
        $this->resetInputFields();

        $this->emit('showMessage');
        $this->emit('refreshDatatable');
        $this->emit('resetSelected');
    }
}
