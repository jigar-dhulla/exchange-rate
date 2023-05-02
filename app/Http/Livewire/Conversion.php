<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Conversion extends Component
{
    /**
     * @var string $from
     */
    public string $from;

    /**
     * @var string $to
     */
    public string $to;

    /**
     * @var string $result
     */
    public ?string $result;

    /**
     * @var array $to
     */
    protected array $rules = [
        'from' => 'required',
        'to' => 'required',
        'result' => 'nullable|float',
    ];

    /**
     * View to render
     */
    public function render()
    {
        return view('livewire.conversion')
            ->extends('layouts.app')
            ->section('content');
    }

    /**
     * Method to convert
     */
    public function convert()
    {
        $this->validate();
        $this->result = "1";
    }
}
