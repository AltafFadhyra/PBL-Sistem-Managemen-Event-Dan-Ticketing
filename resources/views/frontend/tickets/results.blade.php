<x-public-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tiket Ditemukan</h2>
            <p class="mt-2 text-gray-500">Kami menemukan {{ $registrations->count() }} tiket yang terhubung dengan Email <strong>{{ $request->visitor_email }}</strong></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($registrations as $reg)
                <a href="{{ route('registrations.show', $reg->registration_number) }}" class="block bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full mb-2">
                                    {{ $reg->registration_number }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $reg->event->title }}</h3>
                            </div>
                            @if($reg->status === 'paid' || $reg->status === 'registered')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">LUNAS</span>
                            @elseif($reg->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold">PENDING</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">DITOLAK</span>
                            @endif
                        </div>
                        
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                <span>{{ $reg->ticketType->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ $reg->event->start_date->format('d M Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-sm font-medium text-indigo-600 group-hover:text-indigo-700">Lihat E-Ticket &rarr;</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('tickets.search') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">
                &larr; Cari Tiket Lain
            </a>
        </div>
    </div>
</x-public-layout>
