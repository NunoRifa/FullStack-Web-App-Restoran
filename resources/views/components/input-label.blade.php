@props(['value', 'required' => false])

<flux:field class="mb-4">
    <flux:label {{ $attributes->merge($required ? ['badge' => 'required'] : []) }}>
        {{ $value ?? $slot }}
    </flux:label>
</flux:field>
