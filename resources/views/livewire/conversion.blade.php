<div>
    <form class="form pb-3" wire:submit="convert">
        <div class="mb-3">
            <label class="form-label">From</label>
            <select class="form-control" wire:model="from" type="text" name="from">
                <option selected="selected">(Select)</option>
                @foreach($currencies as $currency)
                    <option value="{{$currency}}">{{$currency}}</option>
                @endforeach
            </select>
            @error('from') <div class="form-text text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">To</label>
            <select class="form-control" wire:model="to" type="text" name="to" value="">
                <option selected="selected">(Select)</option>
                @foreach($currencies as $currency)
                    <option value="{{$currency}}">{{$currency}}</option>
                @endforeach
            </select>
            @error('to') <div class="form-text text-danger">{{ $message }}</div> @enderror
        </div>
        <button class="btn btn-primary" type="submit">Convert</button>
    </form>

    @if ($result)
        <div class="alert alert-success">{{ $result }}</div>
    @endif
    
    @if (session()->has('api_error'))
        <div class="alert alert-danger">
            {{ session('api_error') }}
        </div>
    @endif
    
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                    <th scope="col">Rate</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
            @foreach($conversions as $conversion)
                <tr>
                    <td scope="row">{{ $conversion->from }}</th>
                    <td>{{ $conversion->to }}</td>
                    <td>{{ $conversion->result }}</td>
                    <td>{{ $conversion->conversion_date->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>