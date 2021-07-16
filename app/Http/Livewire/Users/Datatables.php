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

class Datatables extends DataTableComponent
{
    protected $listeners = [
        'userRefresh' => '$refresh',
    ];

    /**
     * The Page Name
     */
    protected string $pageName = 'users';

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
     * Setting show all in page options
     */
    public bool $perPageAll = true;

    /**
     * Setting show per page options
     */
    public array $perPageAccepted = [
        5,
        10,
        25,
        50,
        100
    ];

    /**
     * Setting defaut data per page
     */
    public int $perPage  = 5;

    /**
     * setting show action if row selected
     */
    public array $bulkActions = [
        'deleteSelected'   => 'Delete',
    ];

    /**
     * filters default values
     */
    public array $filters = [
        'verified' => '',
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
            'roleFilter' => Filter::make('Role')
                ->select($roleArray),
        ];
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
            Column::make('Role', 'roles')
                ->format(function ($value) {
                    $result = "<span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-jets-100 text-jets-800'> ";
                    $result .= ($value->first()) ? ($value->first()->title) : null;
                    $result .= "</span>";
                    return $result;
                })->asHtml(),
            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),
            Column::make('Verified At', 'email_verified_at')
                ->sortable()
                ->format(function ($value) {
                    return ($value) ? (new Carbon($value))->isoFormat('D MMMM YYYY') : null;
                }),
            Column::make('Created At', 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return ($value) ? (new Carbon($value))->isoFormat('D MMMM YYYY') : null;
                }),
            Column::make('Updated At', 'updated_at')
                ->sortable()
                ->format(function ($value) {
                    return ($value) ? (new Carbon($value))->isoFormat('D MMMM YYYY') : null;
                }),
            Column::make('Actions')
                ->format(function ($value, $column, $row) {
                    return view('livewire.users.action')->with('row', $row);
                }),
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
            ->with(['roles'])
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
            ->when($this->getFilter('roleFilter'), function ($query, $value) {
                $query->whereHas('roles', function ($query) use ($value) {
                    $query->where('id', $value);
                });

                return $query;
            });
    }

    /**
     * delete selected id from table
     *
     * @return void
     */
    public function deleteSelected(): void
    {
        if ($this->selectedRowsQuery->count() > 0) {
            User::whereIn('id', $this->selectedKeys())->delete();
        }

        $this->selected = [];

        $this->resetBulk();
    }

    /**
     * edit
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        $this->emit('userEdit', $id);
    }

    /**
     * edit
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->emit('userDelete', $id);
    }
}
