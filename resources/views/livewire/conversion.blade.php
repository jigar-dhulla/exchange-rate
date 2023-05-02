<div>
    <form wire:submit.prevent="convert">
        <div>
            <label>From</label>
            <input wire:model="from" type="text" name="from" value="" />
            @error('from') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>To</label>
            <input wire:model="to" type="text" name="to" value=""/>
            @error('to') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button type="submit">Convert</button>
    </form>
    <div>{{ $result }}</div>
</div>