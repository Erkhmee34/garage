<x-app-layout>
    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-blue-100">
                <h1 class="text-4xl font-black mb-8 text-blue-900">✏️ Зар засах</h1>

            <form method="POST" action="{{ route('ads.update', $ad) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6 p-4 bg-blue-50 rounded-xl border-2 border-blue-200">
                    <label class="block text-sm font-bold mb-2 text-blue-900">🖼️ Зураг (заавал биш)</label>
                    @if($ad->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-32 h-32 object-cover rounded-xl border-2 border-blue-200">
                            <p class="text-xs text-blue-700 mt-2 font-semibold">Одоо байгаа зураг</p>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="w-full p-3 border-2 border-dashed border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-blue-700 mt-2">Шинэ зураг сонгоно уу (JPG, PNG, GIF. Хамгийн их 5MB)</p>
                    @error('image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Гарчиг <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $ad->title) }}" required class="w-full p-3 border rounded-lg">
                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Тайлбар <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="6" required class="w-full p-3 border rounded-lg">{{ old('description', $ad->description) }}</textarea>
                    @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Төрөл <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full p-3 border rounded-lg">
                        <option value="">Сонгоно уу</option>
                        <option value="Guitars" {{ old('category', $ad->category)=='Guitars' ? 'selected' : '' }}>Гитар</option>
                        <option value="Amps" {{ old('category', $ad->category)=='Amps' ? 'selected' : '' }}>Амп</option>
                        <option value="Pedals" {{ old('category', $ad->category)=='Pedals' ? 'selected' : '' }}>Педаль</option>
                        <option value="Accessories" {{ old('category', $ad->category)=='Accessories' ? 'selected' : '' }}>Хэсэг/Дагалдах хэрэгсэл</option>
                        <option value="Parts" {{ old('category', $ad->category)=='Parts' ? 'selected' : '' }}>Сэлбэг</option>
                        <option value="Services" {{ old('category', $ad->category)=='Services' ? 'selected' : '' }}>Үйлчилгээ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Үнэ (₮)</label>
                    <input type="number" name="price" value="{{ old('price', $ad->price) }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Утасны дугаар</label>
                    <input type="text" name="phone" value="{{ old('phone', $ad->phone) }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Брэнд</label>
                    <input type="text" name="brand" value="{{ old('brand', $ad->brand) }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Загвар</label>
                    <input type="text" name="model" value="{{ old('model', $ad->model) }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">Жил</label>
                        <input type="text" name="year" value="{{ old('year', $ad->year) }}" class="w-full p-3 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Байдал</label>
                        <select name="condition" class="w-full p-3 border rounded-lg">
                            <option value="">Сонгоно уу</option>
                            <option value="New" {{ old('condition', $ad->condition)=='New' ? 'selected' : '' }}>Шинэ</option>
                            <option value="Like New" {{ old('condition', $ad->condition)=='Like New' ? 'selected' : '' }}>Шинэ мэт</option>
                            <option value="Good" {{ old('condition', $ad->condition)=='Good' ? 'selected' : '' }}>Сайн</option>
                            <option value="Fair" {{ old('condition', $ad->condition)=='Fair' ? 'selected' : '' }}>Дундаж</option>
                            <option value="For Parts" {{ old('condition', $ad->condition)=='For Parts' ? 'selected' : '' }}>Сэлбэгэнд</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Байршил (хот)</label>
                    <input type="text" name="location" value="{{ old('location', $ad->location) }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition shadow-lg text-lg">
                        ✏️ Зар засах
                    </button>
                    <a href="{{ route('ads.show', $ad) }}" class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 font-bold transition">← Буцах</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
