@props(['title'])

<div class="block w-full h-full p-6 border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <p class="text-xl font-semibold mb-5">{{ $title }}</p>
    {{ $slot }}
</div>
