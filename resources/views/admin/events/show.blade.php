<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.events.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $event->title }}
            </h2>
            <a href="{{ route('admin.events.edit', $event->id) }}" class="ml-4 bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-bold px-3 py-1 rounded-full border border-amber-300 transition">
                Edit Event
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Event Details -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6 flex flex-col md:flex-row gap-6">
                @if($event->posters->count() > 0)
                    <div class="w-full md:w-1/3 shrink-0">
                        <img src="{{ Storage::url($event->posters->first()->image_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover rounded-xl shadow-sm border border-gray-100 aspect-square md:aspect-[4/5]">
                    </div>
                @else
                    <div class="w-full md:w-1/3 shrink-0 flex items-center justify-center bg-gray-100 rounded-xl border border-gray-200 aspect-[4/5]">
                        <span class="text-gray-400 font-medium">Tidak ada poster</span>
                    </div>
                @endif
                <div class="flex-1">
                    <div class="mb-4">
                        @foreach($event->categories as $category)
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800 inline-block mr-1">{{ $category->name }}</span>
                        @endforeach
                    </div>
                    <p class="text-gray-700 mb-4">{{ $event->description }}</p>
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <strong class="block text-gray-900">Tanggal & Waktu:</strong> 
                            {{ $event->start_date->format('d M Y, H:i') }}
                            @if($event->end_date)
                                - {{ $event->end_date->format('d M Y, H:i') }}
                            @endif
                        </div>
                        <div><strong class="block text-gray-900">Lokasi:</strong> {{ $event->location }}</div>
                        <div><strong class="block text-gray-900">Total Pendaftar:</strong> {{ $event->registrations->count() }} orang</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Ticket Types Management -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-900">Tambah Jenis Tiket</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.events.tickets.store', $event->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tiket (Mis: VIP, VIP Hari 1)</label>
                                    <input type="text" name="name" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berlaku Tiket (Opsional)</label>
                                    <input type="date" name="valid_date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tiket berlaku untuk semua hari (tiket terusan).</p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                                    <input type="number" name="price" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="0" required>
                                    <p class="text-xs text-gray-500 mt-1">Isi 0 untuk tiket gratis.</p>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuota</label>
                                    <input type="number" name="quota" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="1">
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                    Tambah Tiket
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-900">Daftar Tiket</h3>
                        </div>
                        <div class="p-0">
                            <ul class="divide-y divide-gray-200">
                                @forelse ($event->ticketTypes as $ticket)
                                    <li class="p-5 flex flex-col sm:flex-row sm:justify-between sm:items-center hover:bg-indigo-50/50 transition duration-200 border-b border-gray-100 last:border-0 gap-4">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900 text-base mb-2">{{ $ticket->name }}</h4>
                                            <div class="flex flex-wrap gap-2 text-sm text-gray-600 mb-2">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-green-50 text-green-700 font-semibold border border-green-200/60 shadow-sm">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    {{ $ticket->price > 0 ? 'Rp ' . number_format($ticket->price, 0, ',', '.') : 'Gratis' }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 font-semibold border border-blue-200/60 shadow-sm">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    Sisa Kuota: {{ $ticket->quota }}
                                                </span>
                                            </div>
                                            <div>
                                                @if($ticket->valid_date)
                                                    <span class="inline-flex items-center text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">
                                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        Khusus tgl: {{ \Carbon\Carbon::parse($ticket->valid_date)->format('d M Y') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded">
                                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                                        Berlaku semua hari
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Hapus jenis tiket ini? Data pendaftar tidak akan ikut terhapus.');" class="shrink-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 text-red-500 bg-white border border-red-200 hover:bg-red-500 hover:text-white hover:border-red-500 rounded-xl shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" title="Hapus Tiket">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </li>
                                @empty
                                    <li class="p-8 flex flex-col items-center justify-center text-center">
                                        <div class="bg-gray-100 p-3 rounded-full mb-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                        </div>
                                        <p class="text-sm text-gray-500 font-medium">Belum ada tiket yang ditambahkan.</p>
                                        <p class="text-xs text-gray-400 mt-1">Silakan tambah tiket melalui form di atas.</p>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Registrations List -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                        <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Daftar Peserta</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-200">Total: {{ $event->registrations->count() }}</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peserta</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiket</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status & Pembayaran</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($registrations as $reg)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-100">
                                            {{ $reg->registration_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-100">
                                            {{ $reg->visitor_name }}<br>
                                            <span class="text-xs text-gray-500">{{ $reg->visitor_email }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-100">
                                            {{ $reg->ticketType->name }} (Rp{{ number_format($reg->ticketType->price, 0, ',', '.') }})
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-100">
                                            @if($reg->status === 'paid')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                    Sukses
                                                </span>
                                            @elseif($reg->status === 'rejected')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    Tertunda
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-100">
                                            @if($reg->payment_proof)
                                                <a href="{{ Storage::url($reg->payment_proof) }}" target="_blank" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    Lihat
                                                </a>
                                            @else
                                                <span class="text-sm text-gray-400 italic">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border-b border-gray-100 text-right">
                                            @if($reg->status === 'pending')
                                                <div class="flex items-center justify-end space-x-2">
                                                    <form action="{{ route('admin.registrations.approve', $reg->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-1.5 rounded-lg transition-colors" title="Verifikasi">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.registrations.reject', $reg->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" onclick="return confirm('Tolak pendaftaran ini?')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg transition-colors" title="Tolak">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 whitespace-nowrap text-sm text-gray-500 text-center bg-gray-50/50">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                <p>Belum ada pendaftar.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($registrations->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $registrations->links() }}
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
