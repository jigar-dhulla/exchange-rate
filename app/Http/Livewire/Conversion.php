<?php

namespace App\Http\Livewire;

use App\Exceptions\ExchangeRateException;
use App\Services\Contract\ExchangeRate as ExchangeRateContract;
use Livewire\Component;

class Conversion extends Component
{
    /**
     * Assignment Restriction
     */
    private const ALLOWED_SYMBOLS = ['INR', 'EUR'];

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
        try {
            $symbols = $service->getAllowedCurrencies();
            $this->currencies = array_filter($symbols, fn ($symbol) => in_array($symbol, self::ALLOWED_SYMBOLS));
        } catch (ExchangeRateException $e) {
            session()->flash('api_error', $e->getMessage());
        }
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
        try {
            $this->result = $service->convert($this->from, $this->to);
        } catch (ExchangeRateException $e) {
            session()->flash('api_error', $e->getMessage());
        }
    }
}
