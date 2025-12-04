<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8">Шинэ зар оруулах</h1>

            <form method="POST" action="/ads" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Зураг (заавал биш)</label>
                    <input type="file" name="image" accept="image/*" class="w-full p-3 border rounded-lg">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF. Хамгийн их 5MB</p>
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
                        <option value="Vehicles" {{ old('category')=='Vehicles' ? 'selected' : '' }}>Машины зар</option>
                        <option value="Jobs" {{ old('category')=='Jobs' ? 'selected' : '' }}>Ажлын байр</option>
                        <option value="Real Estate" {{ old('category')=='Real Estate' ? 'selected' : '' }}>Үл хөдлөх хөрөнгө</option>
                        <option value="Services" {{ old('category')=='Services' ? 'selected' : '' }}>Үйлчилгээ</option>
                        <option value="For Sale" {{ old('category')=='For Sale' ? 'selected' : '' }}>Зарна</option>
                        <option value="Community" {{ old('category')=='Community' ? 'selected' : '' }}>Нийгэм</option>
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

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700">
                        Зар оруулах
                    </button>
                    <a href="/ads" class="px-6 py-3 border rounded-lg text-gray-700 hover:bg-gray-100">Буцах</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>