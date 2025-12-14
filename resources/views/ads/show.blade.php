<x-app-layout>
    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-2 border-amber-100">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Зураг -->
                    <div class="relative">
                        @if($ad->image)
                            <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}"
                                 class="w-full h-96 object-cover rounded-l-2xl">
                        @else
                            <div class="bg-gray-200 border-2 border-dashed rounded-l-2xl w-full h-96 flex items-center justify-center">
                                <span class="text-2xl text-gray-500">Зураг байхгүй</span>
                            </div>
                        @endif

                        <!-- LIKE BUTTON – ЯГ ОДОО 100% АЖИЛЛАНА! -->
                        <div class="absolute bottom-4 left-4">
                            @auth
                                <div x-data="{ 
                                    liked: {{ $ad->isLikedBy(auth()->user()) ? 'true' : 'false' }}, 
                                    count: {{ $ad->likeCount() }}
                                }">
                                    <button 
                                        @click="
                                            fetch('{{ route('ads.like', $ad) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Content-Type': 'application/json',
                                                    'Accept': 'application/json'
                                                },
                                                body: JSON.stringify({})
                                            })
                                            .then(r => {
                                                if (!r.ok) throw new Error('Алдаа');
                                                return r.json();
                                            })
                                            .then(d => { liked = d.liked; count = d.count; })
                                            .catch(() => alert('Алдаа гарлаа'))
                                        "
                                        class="flex items-center gap-3 px-6 py-4 bg-white/95 backdrop-blur-sm rounded-full shadow-2xl hover:scale-105 transition-all font-bold text-lg"
                                        :class="liked ? 'text-red-600' : 'text-gray-700'"
                                    >
                                        <svg class="w-8 h-8 transition-all" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span x-text="count" class="min-w-10 text-center"></span>
                                        <span x-show="liked" x-transition class="text-red-600 font-bold">Та like дарсан</span>
                                        <span x-show="!liked" x-transition class="text-gray-600">Like дарна уу</span>
                                    </button>
                                </div>
                            @else
                                <div class="flex items-center gap-3 px-6 py-4 bg-white/95 backdrop-blur-sm rounded-full shadow-2xl text-gray-700 font-bold text-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    <span>{{ $ad->likeCount() }}</span>
                                    <span class="font-normal text-base text-gray-500">Нэвтэрч like дарна уу</span>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Мэдээлэл + Товчнууд -->
                    <div class="p-8 flex flex-col justify-between">
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $ad->title }}</h1>
                            
                            @if($ad->price > 0)
                                <p class="text-4xl font-bold text-green-600 mb-6">{{ number_format($ad->price) }}₮</p>
                            @else
                                <p class="text-2xl text-gray-600 italic mb-6">Үнэ тохирно</p>
                            @endif

                            <div class="space-y-6 text-lg">
                                <p class="text-gray-700 leading-relaxed">{{ $ad->description }}</p>
                                
                                <!-- Guitar Specs Section -->
                                @if($ad->brand || $ad->model || $ad->year || $ad->condition)
                                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-5 rounded-xl space-y-3 border-l-4 border-amber-500 shadow-md">
                                        <h3 class="font-bold text-lg text-amber-900">🎸 Гитарын Мэдээлэл</h3>
                                        @if($ad->brand)
                                            <div class="flex justify-between">
                                                <span class="font-semibold text-gray-700">Брэнд:</span>
                                                <span class="text-gray-900">{{ $ad->brand }}</span>
                                            </div>
                                        @endif
                                        @if($ad->model)
                                            <div class="flex justify-between">
                                                <span class="font-semibold text-gray-700">Загвар:</span>
                                                <span class="text-gray-900">{{ $ad->model }}</span>
                                            </div>
                                        @endif
                                        @if($ad->year)
                                            <div class="flex justify-between">
                                                <span class="font-semibold text-gray-700">Жил:</span>
                                                <span class="text-gray-900">{{ $ad->year }}</span>
                                            </div>
                                        @endif
                                        @if($ad->condition)
                                            <div class="flex justify-between">
                                                <span class="font-semibold text-gray-700">Төлөв:</span>
                                                <span class="text-gray-900">{{ ucfirst($ad->condition) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="flex items-center gap-3 text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span>Төрөл: <strong>{{ $ad->category }}</strong></span>
                                </div>

                                @if($ad->location)
                                    <div class="flex items-center gap-3 text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span>Байршил: <strong>{{ $ad->location }}</strong></span>
                                    </div>
                                @endif

                                @if($ad->phone)
                                    <div class="flex items-center gap-3 text-gray-700">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span class="font-bold text-2xl">{{ $ad->phone }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center gap-4 pt-6 border-t text-gray-500">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-lg">
                                        {{ Str::upper(substr($ad->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-lg">{{ $ad->user->name }}</p>
                                        <p class="text-sm">{{ $ad->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex gap-4 flex-wrap">
                            <a href="/ads" class="flex-1 text-center bg-gradient-to-r from-gray-600 to-gray-700 text-white py-4 rounded-xl font-bold hover:from-gray-700 hover:to-gray-800 transition text-lg shadow-md">
                                ← Буцах
                            </a>
                            @if(auth()->check() && auth()->id() === $ad->user_id)
                                <a href="{{ route('ads.edit', $ad) }}" class="px-10 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition text-lg shadow-md">
                                    ✏️ Засах
                                </a>
                                <form action="{{ route('ads.destroy', $ad) }}" method="POST" onsubmit="return confirm('Зар устгаж салахуу?')" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full px-10 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-bold hover:from-red-700 hover:to-red-800 transition text-lg shadow-md">
                                        🗑️ Устгах
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>