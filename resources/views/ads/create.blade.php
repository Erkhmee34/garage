<x-app-layout>
    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-amber-100">
                <h1 class="text-4xl font-black mb-8 text-amber-900">✨ Шинэ гитар зар оруулах</h1>

            <form method="POST" action="/ads" enctype="multipart/form-data">
                @csrf

                <div class="mb-6 p-4 bg-amber-50 rounded-xl border-2 border-amber-200">
                    <label class="block text-sm font-bold mb-2 text-amber-900">🖼️ Зураг (заавал биш)</label>
                    <input type="file" name="image" accept="image/*" class="w-full p-3 border-2 border-dashed border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <p class="text-xs text-amber-700 mt-2">JPG, PNG, GIF. Хамгийн их 5MB</p>
                    @error('image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Гарчиг <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full p-3 border rounded-lg">
                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Тайлбар <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="6" required class="w-full p-3 border rounded-lg">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Категори <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full p-3 border rounded-lg">
                        <option value="">Сонгоно уу</option>
                        <option value="Guitars" {{ old('category')=='Guitars' ? 'selected' : '' }}>Гитар</option>
                        <option value="Amps" {{ old('category')=='Amps' ? 'selected' : '' }}>Амп</option>
                        <option value="Pedals" {{ old('category')=='Pedals' ? 'selected' : '' }}>Педаль</option>
                        <option value="Accessories" {{ old('category')=='Accessories' ? 'selected' : '' }}>Хэсэг/Дагалдах хэрэгсэл</option>
                        <option value="Parts" {{ old('category')=='Parts' ? 'selected' : '' }}>Сэлбэг</option>
                        <option value="Services" {{ old('category')=='Services' ? 'selected' : '' }}>Үйлчилгээ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Үнэ (₮)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Утасны дугаар</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Брэнд</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Модель</label>
                    <input type="text" name="model" value="{{ old('model') }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">Жил</label>
                        <input type="text" name="year" value="{{ old('year') }}" class="w-full p-3 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Байдал</label>
                        <select name="condition" class="w-full p-3 border rounded-lg">
                            <option value="">Сонгоно уу</option>
                            <option value="New" {{ old('condition')=='New' ? 'selected' : '' }}>Шинэ</option>
                            <option value="Like New" {{ old('condition')=='Like New' ? 'selected' : '' }}>Шинэ мэт</option>
                            <option value="Good" {{ old('condition')=='Good' ? 'selected' : '' }}>Сайн</option>
                            <option value="Fair" {{ old('condition')=='Fair' ? 'selected' : '' }}>Дундаж</option>
                            <option value="For Parts" {{ old('condition')=='For Parts' ? 'selected' : '' }}>Сэлбэгэнд</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Байршил (хот)</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="w-full p-3 border rounded-lg">
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-bold hover:from-green-600 hover:to-emerald-700 transition shadow-lg text-lg">
                        ✨ Зар оруулах
                    </button>
                    <a href="/ads" class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 font-bold transition">← Буцах</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>