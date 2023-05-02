<?php

namespace App\Http\Livewire;

use App\Services\Contract\ExchangeRate as ExchangeRateContract;
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
     * @var float $result
     */
    public ?float $result;

    /**
     * @var array $currencies
     */
    public array $currencies;

    /**
     * @var array $to
     */
    protected array $rules = [
        'from' => 'required',
        'to' => 'required',
        'result' => 'nullable|numeric',
    ];

    public function mount(ExchangeRateContract $service)
    {
        $this->currencies = $service->getAllowedCurrencies();
    }

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
    public function convert(ExchangeRateContract $service)
    {
        $this->validate();
        $this->result = $service->convert($this->from, $this->to);
    }
}
