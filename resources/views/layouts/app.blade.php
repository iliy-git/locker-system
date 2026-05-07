<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @livewireStyles
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ru.js"></script>

    <!-- Lucide icons (если ещё не подключены) -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
    <!-- Глобальные стили для полноэкранного режима -->
    <style>
        html, body {
            height: 100%;
            width: 100%;
            overflow-x: hidden; /* Убираем горизонтальный скролл страницы */
        }
        /* Чтобы компонент мог скроллиться внутри, а не вся страница */
        .fullscreen-slot {
            height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#0b0f19] text-slate-200 h-full w-full overflow-hidden">

<!-- Контейнер на весь экран -->
<div class="fullscreen-slot">
    {{ $slot }}
</div>

@livewireScripts
<script>
    lucide.createIcons();
    document.addEventListener('livewire:navigated', () => lucide.createIcons());
</script>
</body>
</html>
