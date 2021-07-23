<?php

declare(strict_types=1);

namespace App\Http\Livewire\Users;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class Datatables extends DataTableComponent
{
    /**
     * listen event.
     *
     * @var array
     */
    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'resetSelected' => 'resetSelected',
    ];

    /**
     * The Table Name
     */
    protected string $tableName = 'users';

    /**
     * Table primary key
     */
    public string $primaryKey = 'id';

    /**
     * Setting show options to show column name
     */
    public bool $columnSelect = true;

    /**
     * setting defaut sorting column name
     */
    public string $defaultSortColumn = 'name';

    /**
     * setting defaut sorting direction
     */
    public string $defaultSortDirection  = 'asc';

    /**
     * setting defaut for sorting only one column
     */
    public bool $singleColumnSorting  = true;

    /**
     * setting for hide action when not selected row
     */
    public bool $hideBulkActionsOnEmpty = true;

    /**
     * Setting for pagination name
     */
    protected string $pageName = 'page';

    /**
     * Setting show all in pagination options
     */
    public bool $perPageAll = true;

    /**
     * Setting show per pagination options
     */
    public array $perPageAccepted = [
        5,
        10,
        25,
        50,
        100
    ];

    /**
     * Setting defaut data pagination page
     */
    public int $perPage  = 5;

    /**
     * setting for number column
     *
     * @var int
     */
    public int $number = 1;

    /**
     * setting show action if row selected
     */
    public array $bulkActions = [];

    /**
     * filters default values
     */
    public array $filters = [
        'verified' => '',
        'activeFilter' => '',
        'roleFilter' => '',
    ];

    /**
     * filters Setting
     *
     * @return array
     */
    public function filters(): array
    {
        $roleArray = [
            0 => 'All'
        ];
        $role = Role::orderBy('title')->get()->pluck('title', 'id')->toArray();
        $roleArray = array_merge($roleArray, $role);

        return [
            'verified' => Filter::make('E-mail Verified')
                ->select([
                    ''    => 'All',
                    'yes' => 'Yes',
                    'no'  => 'No',
                ]),
            'verifiedFrom' => Filter::make('Verified From')
                ->date([
                    'max' => now()->isoFormat('YYYY-MM-DD')
                ]),
            'verifiedTo' => Filter::make('Verified To')
                ->date([
                    'max' => now()->isoFormat('YYYY-MM-DD')
                ]),
            'activeFilter' => Filter::make('Active')
                ->select([
                    ''    => 'All',
                    'yes' => 'Yes',
                    'no'  => 'No',
                ]),
            'roleFilter' => Filter::make('Role')
                ->select($roleArray),
        ];
    }

    /**
     * Query for table data
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return User::query()
            ->with(['role','updatedBy'])
            ->when($this->getFilter('verified'), function ($query, $verified) {
                if ($verified === 'yes') {
                    return $query->whereNotNull('email_verified_at');
                }

                return $query->whereNull('email_verified_at');
            })
            ->when($this->getFilter('verifiedFrom'), function ($query, $date) {
                return $query->where('email_verified_at', '>=', $date);
            })
            ->when($this->getFilter('verifiedTo'), function ($query, $date) {
                return $query->where('email_verified_at', '<=', $date);
            })
            ->when($this->getFilter('activeFilter'), function ($query, $active) {
                if ($active === 'yes') {
                    return $query->where('is_active', 1);
                }

                return $query->where('is_active', 0);
            })
            ->when($this->getFilter('roleFilter'), function ($query, $value) {
                $query->whereHas('role', function ($query) use ($value) {
                    $query->where('id', $value);
                });

                return $query;
            });
    }

    /**
     * mount variable
     *
     * @return void
     */
    public function mount(): void
    {
        $action = [];

        if (Gate::allows('userDelete')) {
            $action = Arr::add($action, 'deleteSelected', 'Delete');
        }

        if (Gate::allows('userActivate')) {
            $action = Arr::add($action, 'activate', 'Activate');
        }

        if (Gate::allows('userDeactivate')) {
            $action = Arr::add($action, 'deactivate', 'Deactivate');
        }

        $this->bulkActions = $action;
    }

    /**
     * List Of Table
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),
            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),
            Column::make('Role', 'role'),
            Column::make('Active', 'is_active'),
            Column::make('Last Updated', 'updated_at')
                ->sortable()
                ->searchable(),
            Column::make('Actions'),
        ];
    }

    /**
     * view for datatables
     *
     * @return string
     */
    public function rowView(): string
    {
        return 'livewire.users.datatables';
    }

    /**
     * reset for bulk action
     *
     * @return void
     */
    public function resetSelected(): void
    {
        $this->selected = [];
        $this->resetBulk(); // Clear the selected rows
        $this->resetPage(); // Go back to page 1
    }

    /**
     * delete selected id from table
     *
     * @return void
     */
    public function deleteSelected(): void
    {
        $this->emit('userMultipleDelete', $this->selectedKeys());
    }

    /**
     * activate selected id from table
     *
     * @return void
     */
    public function activate(): void
    {
        if ($this->selectedRowsQuery->count() > 0) {
            User::whereIn('id', $this->selectedKeys())->update(['is_active' => 1]);
        }

        $this->resetSelected();
    }

    /**
     * deactivate selected id from table
     *
     * @return void
     */
    public function deactivate(): void
    {
        if ($this->selectedRowsQuery->count() > 0) {
            User::whereIn('id', $this->selectedKeys())->update(['is_active' => 0]);
        }

        $this->resetSelected();
    }
}
