<?php

declare(strict_types=1);

namespace App\Http\Livewire\Role;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;

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
    protected string $tableName = 'roles';

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
    public string $defaultSortColumn = 'title';

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
        'activeFilter' => '',
    ];

    /**
     * filters Setting
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            'activeFilter' => Filter::make('Active')
                ->select([
                    ''    => 'All',
                    'yes' => 'Yes',
                    'no'  => 'No',
                ])
        ];
    }

    /**
     * Query for table data
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return Role::query()
            ->when($this->getFilter('activeFilter'), function ($query, $active) {
                if ($active === 'yes') {
                    return $query->where('is_active', 1);
                }

                return $query->where('is_active', 0);
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

        if (Gate::allows('roleDelete')) {
            $action = Arr::add($action, 'deleteSelected', 'Delete');
        }

        if (Gate::allows('roleActivate')) {
            $action = Arr::add($action, 'activate', 'Activate');
        }

        if (Gate::allows('roleDeactivate')) {
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
            Column::make('Title', 'title')
                ->sortable()
                ->searchable(),
            Column::make('Detail', 'detail'),
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
        return 'livewire.role.datatables';
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
            Role::whereIn('id', $this->selectedKeys())->update(['is_active' => 1]);
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
            Role::whereIn('id', $this->selectedKeys())->update(['is_active' => 0]);
        }

        $this->resetSelected();
    }
}
