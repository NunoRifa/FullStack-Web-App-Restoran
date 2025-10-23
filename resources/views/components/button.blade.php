@php
    $colorClasses = [
        'blue' => 'bg-blue-600 hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:ring-blue-500',
        'red' => 'bg-red-600 hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:ring-red-500',
        'green' => 'bg-green-600 hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:ring-green-500',
        'gray' => 'bg-gray-600 hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-700 focus:ring-gray-500',
        'zinc' => 'bg-zinc-600 hover:bg-zinc-500 focus:bg-zinc-500 active:bg-zinc-700 focus:ring-zinc-500',
        'neutral' => 'bg-neutral-600 hover:bg-neutral-500 focus:bg-neutral-500 active:bg-neutral-700 focus:ring-neutral-500',
    ];
    $classes = $colorClasses[$attributes->get('color', 'gray')] ?? $colorClasses['gray'];
@endphp

<button
    {{ $attributes->merge([
        'class' => "inline-flex items-center justify-center text-center mb-1 sm:mx-px py-2 sm:px-3
                    border border-transparent rounded-md font-semibold text-xs text-white uppercase
                    tracking-widest w-2/3 sm:w-auto focus:outline-none focus:ring-2
                    focus:ring-offset-2 transition ease-in-out duration-150 $classes"
    ]) }}
>
    {{ $slot }}
</button>
