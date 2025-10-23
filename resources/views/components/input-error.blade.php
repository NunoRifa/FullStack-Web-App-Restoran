@props(['messages'])

@if ($messages)
    <div class="mt-1 space-y-1">
        @foreach ((array) $messages as $message)
            <flux:text color="red" class="text-sm">{{ $message }}</flux:text>
        @endforeach
    </div>
@endif
