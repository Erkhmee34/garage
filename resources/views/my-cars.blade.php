<!DOCTYPE html>
<html>
<head>
    <title>Миний машинууд</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold mb-8">Таны машинууд</h1>

    @if($cars->count() == 0)
        <p class="text-red-600 text-xl">Утасны дугаараар машин олдсонгүй.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cars as $car)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @if($car->image)
                        <img src="{{ asset('storage/'.$car->image) }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h3 class="text-2xl font-bold">{{ $car->plate_number }}</h3>
                        <p class="text-gray-600">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</p>
                        <p class="mt-4 text-green-600 font-bold">Таны машин манайд байгаа</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-8">
        <a href="{{ url('/') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg">Буцах</a>
    </div>
</div>
</body>
</html>