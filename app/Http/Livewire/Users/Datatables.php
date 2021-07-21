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

    public function setTableRowId($row): ?string
    {
        return $row->uuid;
    }

    /**
     * List Of Table
     *
     * @return array
     */
    public function columns(): array
    {
        $this->number = ($this->page) ? (($this->page - 1) * $this->perPage) + 1 : 0;

        return [
            Column::make('No.')
                ->format(function () {
                    return $this->number++;
                }),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Role', 'role')
                ->format(function ($value) {
                    $result = "<span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-jets-100 text-jets-800'> ";
                    $result .= ($value) ? ($value->title) : null;
                    $result .= "</span>";
                    return $result;
                })->asHtml(),
            Column::make('Email')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy('email', $direction);
                })
                ->searchable()
                ->format(function ($value, $column, $row) {
                    $emailVerifiedAt = ($row->email_verified_at) ? (new Carbon($row->email_verified_at))->isoFormat('D MMMM YYYY') : null;
                    $result = "<div class='text-sm text-gray-900'> " . $row->email . "</div>";
                    $result .= "<div class='text-sm text-gray-500'> Verified At: " . $emailVerifiedAt . "</div>";
                    return $result;
                })->asHtml(),
            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),
            Column::make('Last Updated')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy('updated_at', $direction);
                })
                ->format(function ($value, $column, $row) {
                    $updatedAt = ($row->updated_at) ? (new Carbon($row->updated_at))->isoFormat('D MMMM YYYY') : null;
                    $result = "<div class='text-sm text-gray-900'> At: " . $updatedAt . "</div>";
                    $result .= "<div class='text-sm text-gray-500'> By: " . $row->updatedBy->name . "</div>";
                    return $result;
                })->asHtml(),
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
            ->when($this->getFilter('roleFilter'), function ($query, $value) {
                $query->whereHas('role', function ($query) use ($value) {
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
}
