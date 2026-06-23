<x-public-layout>
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-white">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-y-0 w-full h-full bg-gradient-to-br from-indigo-50 to-purple-50"></div>
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-purple-200/50 blur-3xl mix-blend-multiply"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-200/50 blur-3xl mix-blend-multiply"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-20 pb-24 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
                Temukan Event Terbaik<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">di Sekitarmu</span>
            </h1>
            <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                Beli tiket event favoritmu dengan mudah, cepat, dan aman. Mulai dari konser musik, seminar, hingga workshop inspiratif.
            </p>
        </div>
    </div>

    <!-- Event List Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20">
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Event Mendatang</h2>
        </div>

        <x-event-filter :categories="$categories" />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($events as $event)
                <a href="{{ route('events.show', $event->slug) }}" class="group block bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative h-56 overflow-hidden bg-gray-200">
                        @if($event->posters->count() > 0)
                            <img src="{{ Storage::url($event->posters->first()->image_path) }}" alt="{{ $event->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 font-medium">Event Image</span>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 flex flex-wrap gap-1">
                            @foreach($event->categories as $category)
                                <span class="px-3 py-1 bg-white/90 backdrop-blur text-indigo-700 text-xs font-bold rounded-full shadow-sm">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $event->start_date->format('d M Y') }}
                            @if($event->end_date)
                                - {{ $event->end_date->format('d M Y') }}
                            @endif
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 text-gray-400 mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Belum ada Event</h3>
                    <p class="mt-2 text-gray-500 max-w-sm mx-auto">Kami sedang mempersiapkan berbagai event menarik untuk Anda. Silakan kunjungi kembali nanti!</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 mb-8">
            {{ $events->links() }}
        </div>
    </div>
</x-public-layout>
