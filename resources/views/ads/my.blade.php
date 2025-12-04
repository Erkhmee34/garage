<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8">Миний зарууд</h1>
            <a href="/ads/create" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 mb-6 inline-block">Шинэ зар</a>
            @forelse($ads as $ad)
                <div class="bg-white p-6 rounded-lg shadow mb-4">
                    <h3 class="text-xl font-bold">{{ $ad->title }}</h3>
                    <p>{{ Str::limit($ad->description, 100) }}</p>
                    <a href="/ads/{{ $ad->id }}" class="text-blue-600">Дэлгэрэнгүй</a>
                </div>
            @empty
                <p>Зар алга. Шинэ зар оруулаарай!</p>
            @endforelse
            {{ $ads->links() }}
        </div>
    </div>
</x-app-layout>