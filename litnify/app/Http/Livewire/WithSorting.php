<?php

namespace App\Http\Livewire;

trait WithSorting
{
    public $sortBy = '';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        $this->sortBy = $field;

        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
        : 'asc';
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
}
