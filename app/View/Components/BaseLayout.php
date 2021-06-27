<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;

class BaseLayout extends Component
{
    /**
     * title page
     *
     * @var string|null
     */
    public $title;

    /**
     * Create a new component instance.
     *
     * @param string|null $title
     */
    public function __construct(?string $title = null)
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.base');
    }
}
