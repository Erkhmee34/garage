<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Үнэгүй Зар - Garage</h1>
                <p class="text-xl text-gray-600">Монголын хамгийн том зарын сайт</p>
            </div>

            <!-- Хайлт + Категори -->
            <form method="GET" action="/ads" class="mb-10">
                <div class="flex flex-col md:flex-row gap-4 max-w-3xl mx-auto">
                    <input type="text" name="search" placeholder="Зар хайх..." value="{{ request('search') }}"
                           class="flex-1 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select name="category" class="px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Бүх категори</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Хайх
                    </button>
                </div>
            </form>

            <!-- Шинэ зар оруулах товч -->
            <div class="text-center mb-10">
                @auth
                    <a href="{{ url('/ads/create') }}" class="inline-block bg-green-600 text-white px-10 py-4 rounded-lg text-lg font-bold hover:bg-green-700 transition shadow-lg">
                        Шинэ зар оруулах
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-block bg-green-600 text-white px-10 py-4 rounded-lg text-lg font-bold hover:bg-green-700 transition shadow-lg">
                        Бүртгүүлээд зар оруул
                    </a>
                @endauth
            </div>

            @if($ads->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($ads as $ad)
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden relative group">
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
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($ad->description, 80) }}</p>

                                    @if($ad->price > 0)
                                        <p class="text-2xl font-bold text-green-600 mb-2">{{ number_format($ad->price) }}₮</p>
                                    @else
                                        <p class="text-gray-500 italic mb-2">Үнэ тохирно</p>
                                    @endif

                                    <div class="flex justify-between items-center text-sm text-gray-500">
                                        <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $ad->category }}</span>
                                        <span>{{ $ad->created_at->diffForHumans() }}</span>
                                    </div>
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