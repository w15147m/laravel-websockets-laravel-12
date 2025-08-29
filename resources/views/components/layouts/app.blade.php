<x-layouts.app.sidebar :title="$title ?? null">
    @auth
    <meta name="user-id" content="{{ auth()->id() }}">
@endauth
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
