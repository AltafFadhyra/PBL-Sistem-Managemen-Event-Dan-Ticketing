<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.events.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Event') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Event</label>
                                <input type="text" name="title" id="title" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('title', $event->title) }}" required onkeyup="generateSlug()">
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                                <input type="text" name="slug" id="slug" class="w-full rounded-lg border-gray-300 shadow-sm bg-gray-50 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('slug', $event->slug) }}" required>
                                @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori (Pilih minimal satu)</label>
                                <div class="space-y-2 max-h-48 overflow-y-auto p-2 border border-gray-300 rounded-lg">
                                    @php
                                        $eventCategoryIds = old('categories', $event->categories->pluck('id')->toArray());
                                    @endphp
                                    @foreach($categories as $category)
                                        <div class="flex items-center">
                                            <input id="cat_{{ $category->id }}" name="categories[]" type="checkbox" value="{{ $category->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ in_array($category->id, $eventCategoryIds) ? 'checked' : '' }}>
                                            <label for="cat_{{ $category->id }}" class="ml-2 block text-sm text-gray-900">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('categories') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                <input type="datetime-local" name="start_date" id="start_date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required>
                                @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai (Opsional)</label>
                                <input type="datetime-local" name="end_date" id="end_date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}">
                                @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                <input type="text" name="location" id="location" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('location', $event->location) }}" required>
                                @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Poster Event</label>
                                @if($event->posters->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                        @foreach($event->posters as $poster)
                                            <div class="relative rounded-lg overflow-hidden border border-gray-200">
                                                <img src="{{ Storage::url($poster->image_path) }}" class="w-full h-32 object-cover" alt="Poster">
                                                <div class="absolute top-2 right-2 flex items-center justify-center">
                                                    <button type="button" onclick="if(confirm('Hapus poster ini?')) { document.getElementById('delete-poster-{{ $poster->id }}').submit(); }" class="bg-red-500 hover:bg-red-600 shadow text-white p-1.5 rounded-full" title="Hapus Gambar">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <label for="posters" class="block text-sm font-medium text-gray-700 mb-2">Tambah Poster Event (Opsional, bisa lebih dari satu)</label>
                                <input type="file" name="posters[]" id="posters" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition" accept="image/*" multiple>
                                @error('posters') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                @error('posters.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>



                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" id="description" rows="5" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description', $event->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end mt-8">
                            <a href="{{ route('admin.events.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 border border-transparent rounded-lg shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulir rahasia untuk hapus poster (Harus berada di luar form utama) -->
    @foreach($event->posters as $poster)
        <form id="delete-poster-{{ $poster->id }}" action="{{ route('admin.posters.destroy', $poster->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    @push('scripts')
    <script>
        function generateSlug() {
            let title = document.getElementById('title').value;
            let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            document.getElementById('slug').value = slug;
        }
    </script>
    @endpush
</x-app-layout>
