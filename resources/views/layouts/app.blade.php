<!DOCTYPE html>
<html lang="mn" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Guitar Garage – Монголын гитарны №1 сайт</title>
    <meta name="description" content="Зөвхөн гитар, зөвхөн Монголд. Шинэ, хуучин, акустик, электр, амп, педал – бүгд энд.">

    <!-- Google Font: Inter (маш гоё харагдана) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CDN + Чиний хүссэн дулаахан палитр (npm run build хийх шаардлагагүй! -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        cream:    '#FFFCF7',
                        sand:     '#F5F0E9',
                        olive:    '#8A9A5B',
                        forest:   '#3D4F3A',
                        burnt:    '#D97706',
                        gold:    '#B89146',
                        rose:     '#E8B4B8',
                        slate:    '#475569',
                        warmgray: '#78716C',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js (Like-д хэрэгтэй) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-cream text-slate min-h-screen antialiased">

    <!-- Чиний navigation энд байвал оруул -->
    @include('layouts.navigation')

    <!-- Main content -->
    <main>
        {{ $slot }}
    </main>

</body>
</html>