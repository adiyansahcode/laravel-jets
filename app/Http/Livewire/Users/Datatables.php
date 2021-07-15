<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Carbon\Carbon;

class Datatables extends DataTableComponent
{
    protected string $pageName = 'users';

    protected string $tableName = 'users';

    public string $primaryKey = 'id';

    public bool $columnSelect = true;

    public string $defaultSortColumn = 'name';

    public string $defaultSortDirection  = 'asc';

    public bool $singleColumnSorting  = true;

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
        'role' => '',
    ];

    /**
     * filters Setting
     *
     * @return array
     */
    public function filters(): array
    {
        $roleArray = [
            '' => 'All'
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
            'role' => Filter::make('Role')
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
                    $result = "<span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-jets-100 text-jets-800'> " . $value->first()->title . "</span>";
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
                    return view('users.action')->with('row', $row);
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
            ->when($this->getFilter('role'), function ($query, $value) {
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

    // public function modalsView(): string
    // {
    //     return 'users.create';
    // }

    // public function rowView(): string
    // {
    //     return 'users.rowView';
    // }
}
