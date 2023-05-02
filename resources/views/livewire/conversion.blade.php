<div>
    <form wire:submit.prevent="convert">
        <div>
            <label>From</label>
            <select wire:model="from" type="text" name="from">
                <option>(Select)</option>
                @foreach($currencies as $currency)
                    <option value="{{$currency}}">{{$currency}}</option>
                @endforeach
            </select>
            @error('from') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>To</label>
            <select wire:model="to" type="text" name="to" value="">
                <option>(Select)</option>
                @foreach($currencies as $currency)
                    <option value="{{$currency}}">{{$currency}}</option>
                @endforeach
            </select>
            @error('to') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button type="submit">Convert</button>
    </form>
    <div>{{ $result }}</div>
    
    @if (session()->has('api_error'))
        <div>
            {{ session('api_error') }}
        </div>
    @endif
</div>