<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-12 bg-gradient-to-r from-amber-900 via-orange-800 to-red-900 rounded-2xl p-12 text-white shadow-2xl">
                <h1 class="text-5xl font-black mb-4 drop-shadow-lg">🎸 Гитарын Зар</h1>
                <p class="text-2xl font-semibold mb-2">Mongolian Guitar Marketplace</p>
                <p class="text-lg text-amber-100">Монголын хамгийн сайн гитар, амп, педал худалдаа-сунгалтын сайт</p>
            </div>

            <!-- Хайлт + Категори -->
            <form method="GET" action="/ads" class="mb-10">
                <div class="flex flex-col md:flex-row gap-4 max-w-4xl mx-auto">
                    <input type="text" name="search" placeholder="🔍 Гитар, амп, педал хайх..." value="{{ request('search') }}"
                           class="flex-1 px-5 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 shadow-md">
                    <select name="category" class="px-5 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 shadow-md">
                        <option value="">Бүх төрөл</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-gradient-to-r from-amber-600 to-orange-600 text-white px-8 py-3 rounded-xl font-bold hover:from-amber-700 hover:to-orange-700 transition shadow-lg">
                        Хайх
                    </button>
                </div>
            </form>

            <!-- Шинэ зар оруулах товч -->
            <div class="text-center mb-10">
                @auth
                    <a href="{{ url('/ads/create') }}" class="inline-block bg-gradient-to-r from-green-500 to-emerald-600 text-white px-12 py-4 rounded-xl text-lg font-bold hover:from-green-600 hover:to-emerald-700 transition shadow-2xl transform hover:scale-105">
                        ✨ Шинэ зар оруулах
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-block bg-gradient-to-r from-green-500 to-emerald-600 text-white px-12 py-4 rounded-xl text-lg font-bold hover:from-green-600 hover:to-emerald-700 transition shadow-2xl transform hover:scale-105">
                        ✨ Бүртгүүлээд зар орууд
                    </a>
                @endauth
            </div>

            @if($ads->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($ads as $ad)
                        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden relative group border-2 border-gray-100 hover:border-amber-400">
                            <a href="{{ url('/ads/' . $ad->id) }}">
                                @if($ad->image)
                                    <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}"
                                         class="w-full h-56 object-cover transition-transform group-hover:scale-105 duration-300">
                                @else
                                    <div class="bg-gray-200 border-2 border-dashed rounded-t-xl w-full h-56 flex items-center justify-center">
                                        <span class="text-gray-500 text-lg">Зураг байхгүй</span>
                                    </div>
                                @endif

                                <div class="p-5">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $ad->title }}</h3>
                                    
                                    <!-- Guitar Specs -->
                                    @if($ad->brand || $ad->model || $ad->year)
                                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-3 rounded-lg mb-2 border-l-4 border-amber-500 space-y-1">
                                            @if($ad->brand)
                                                <p class="text-sm"><strong class="text-amber-700">🎸 Брэнд:</strong> <span class="text-gray-900">{{ $ad->brand }}</span></p>
                                            @endif
                                            @if($ad->model)
                                                <p class="text-sm"><strong class="text-amber-700">Загвар:</strong> <span class="text-gray-900">{{ $ad->model }}</span></p>
                                            @endif
                                            @if($ad->year)
                                                <p class="text-sm"><strong class="text-amber-700">📅 Жил:</strong> <span class="text-gray-900">{{ $ad->year }}</span></p>
                                            @endif
                                        </div>
                                    @endif

                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($ad->description, 80) }}</p>

                                    @if($ad->price > 0)
                                        <p class="text-2xl font-bold text-green-600 mb-2">{{ number_format($ad->price) }}₮</p>
                                    @else
                                        <p class="text-gray-500 italic mb-2">Үнэ тохирно</p>
                                    @endif

                                    <div class="flex justify-between items-center text-sm text-gray-500 mb-2">
                                        <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $ad->category }}</span>
                                        <span>{{ $ad->created_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- Condition & Location -->
                                    @if($ad->condition || $ad->location)
                                        <div class="flex gap-2 text-xs text-gray-600">
                                            @if($ad->condition)
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Төлөв: {{ ucfirst($ad->condition) }}</span>
                                            @endif
                                            @if($ad->location)
                                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded">📍 {{ $ad->location }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <!-- LIKE BUTTON – ЯГ ЭНД, БҮР ТӨГС АЖИЛЛАНА! -->
                            <div class="px-5 pb-5">
                                @auth
                                    <div x-data="likeButton({{ $ad->id }}, {{ $ad->isLikedBy(auth()->user()) ? 'true' : 'false' }}, {{ $ad->likeCount() }})">
                                        <button @click="toggleLike"
                                            class="flex items-center gap-2 px-5 py-3 rounded-full font-bold text-sm transition-all shadow-md hover:shadow-lg border-2"
                                            :class="liked ? 'bg-red-500 text-white border-red-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'">
                                            <svg class="w-6 h-6" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                            <span x-text="count" class="min-w-8 text-center"></span>
                                            <span x-show="liked" x-transition class="ml-1 text-white">Та like дарсан</span>
                                            <span x-show="!liked" x-transition class="ml-1">Like дарна уу</span>
                                        </button>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 px-5 py-3 bg-gray-100 rounded-full text-sm text-gray-600 font-medium">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span>{{ $ad->likeCount() }}</span>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">{{ $ads->links() }}</div>
            @else
                <div class="text-center py-20">
                    <p class="text-2xl text-gray-500">Зар олдсонгүй</p>
                    <p class="text-gray-400 mt-2">Анхны зарыг та оруулаарай!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Alpine.js + Like функц – ЯГ ЭНД, ХУУДАСНЫ ТӨГСГӨЛД, НЭГ УДАА Л! -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function likeButton(adId, initialLiked, initialCount) {
            return {
                liked: initialLiked,
                count: initialCount,
                async toggleLike() {
                    try {
                        const response = await fetch(`/ads/${adId}/like`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({})
                        });

                        if (!response.ok) throw new Error('Алдаа: ' + response.status);

                        const data = await response.json();
                        this.liked = data.liked;
                        this.count = data.count;
                    } catch (error) {
                        console.error('Like алдаа:', error);
                        alert('Like дарж чадсангүй!');
                    }
                }
            }
        }
    </script>
</x-app-layout>