{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Миний Dashboard - Бүх зарууд
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Шинэ зар оруулах товч -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 text-right">
                <a href="{{ url('/ads/create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition">
                    Шинэ зар оруулах
                </a>
            </div>

            <!-- Бүх зарын жагсаалт (AdController@index-ийн адил) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @auth
                        <h3 class="text-lg font-bold mb-4">Таны оруулсан зарууд ({{ auth()->user()->ads->count() }})</h3>
                        @if(auth()->user()->ads->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                                @foreach(auth()->user()->ads()->latest()->get() as $ad)
                                    <div class="border rounded-lg p-5 hover:shadow-lg transition">
                                        <h4 class="font-bold text-lg">{{ $ad->title }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ Str::limit($ad->description, 80) }}</p>
                                        @if($ad->price)
                                            <p class="text-green-600 font-bold mt-2">{{ number_format($ad->price) }}₮</p>
                                        @endif
                                        <div class="flex justify-between items-center mt-4 text-sm">
                                            <span class="text-gray-500">{{ $ad->created_at->diffForHumans() }}</span>
                                            <a href="/ads/{{ $ad->id }}" class="text-blue-600 hover:underline">Харах →</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Та одоогоор зар оруулаагүй байна.</p>
                        @endif
                    @endauth

                    <hr class="my-8">

                    <h3 class="text-2xl font-bold mb-6">Сүүлийн үеийн бүх зарууд</h3>

                    @if($ads->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($ads as $ad)
                                <div class="border rounded-lg p-5 hover:shadow-lg transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-lg">{{ $ad->title }}</h4>
                                        @if($ad->user_id == auth()->id())
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Таны зар</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 text-sm">{{ Str::limit($ad->description, 80) }}</p>
                                    @if($ad->price)
                                        <p class="text-green-600 font-bold mt-2">{{ number_format($ad->price) }}₮</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-2">{{ $ad->category }} • {{ $ad->created_at->diffForHumans() }}</p>
                                    <div class="mt-3">
                                        <a href="/ads/{{ $ad->id }}" class="text-blue-600 hover:underline text-sm">Дэлгэрэнгүй →</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8">
                            {{ $ads->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500">Одоогоор зар алга байна.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    // Ямар ч скрипт хэрэггүй, гэхдээ хэрвээ хэрэгтэй бол энд нэмнэ
</script>
@endpush