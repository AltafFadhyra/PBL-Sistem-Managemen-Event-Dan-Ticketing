@props(['categories'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 relative z-20">
    <div class="flex items-center mb-4 text-gray-900 font-bold text-lg">
        <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
        Filter Event
    </div>

    <!-- Category Pills -->
    <div class="flex flex-wrap gap-2 mb-6">
        @php
            $currentCategory = request('category');
        @endphp
        
        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" 
           class="px-4 py-1.5 rounded-full text-sm font-semibold transition-colors duration-200 border 
           {{ !$currentCategory ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-gray-600 border-gray-200 hover:border-amber-300 hover:text-amber-600' }}">
            Semua
        </a>
        
        @foreach($categories as $category)
            <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug]) }}" 
               class="px-4 py-1.5 rounded-full text-sm font-semibold transition-colors duration-200 border 
               {{ $currentCategory == $category->slug ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-gray-600 border-gray-200 hover:border-amber-300 hover:text-amber-600' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- Filter Form -->
    <form action="{{ url()->current() }}" method="GET">
        <!-- Preserve category filter in the form so it isn't lost on submit -->
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif

        <div class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:w-1/3">
                <label for="search" class="block text-xs font-medium text-gray-500 mb-1">Filter Berdasarkan Judul/Lokasi</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ketik judul event atau lokasi..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm">
            </div>
            <div class="w-full md:w-1/3">
                <label for="date" class="block text-xs font-medium text-gray-500 mb-1">Filter Berdasarkan Tanggal</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm">
            </div>
            <div class="w-full md:w-auto flex gap-2">
                <button type="submit" class="inline-flex items-center justify-center bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition duration-300 w-full md:w-auto text-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Terapkan Filter
                </button>
                <a href="{{ url()->current() }}" class="inline-flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600 font-medium border border-gray-200 py-2 px-4 rounded-lg transition duration-300 w-full md:w-auto text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>
