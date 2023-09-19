<?php

namespace App\Livewire;

use App\Exceptions\ExchangeRateException;
use App\Models\Conversion as ConversionModel;
use App\Services\Contract\ExchangeRate as ExchangeRateContract;
use Illuminate\Database\Eloquent\Collection;
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
        'from' => 'required|string|size:3',
        'to' => 'required|string|size:3',
        'result' => 'nullable|numeric',
    ];

    /**
     * @var Collection $conversions
     */
    public Collection $conversions;

    public function mount(ExchangeRateContract $service)
    {
        try {
            $symbols = $service->getAllowedCurrencies();
            $this->currencies = array_filter($symbols, fn ($symbol) => in_array($symbol, self::ALLOWED_SYMBOLS));
            $this->conversions = $this->getConversions();
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
        $this->result = null;
        $this->validate();
        try {
            $this->result = $service->convert($this->from, $this->to);
        } catch (ExchangeRateException $e) {
            session()->flash('api_error', $e->getMessage());
        }

        if($this->result){
            ConversionModel::updateOrCreate([
                'from' => $this->from,
                'to' => $this->to,
                'conversion_date' => now()->format('Y-m-d'),
            ], [
                'result' => $this->result,
            ]);
        }
    }

    private function getConversions($limit = null)
    {
        $limit ??= (int) config('app.pagination_limit', 10);
        return ConversionModel::take($limit)->orderBy('conversion_date', 'desc')->get();
    }
}
