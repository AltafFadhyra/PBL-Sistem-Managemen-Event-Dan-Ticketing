<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl shadow-xl overflow-hidden mb-8">
                <div class="px-8 py-10 text-white relative z-10">
                    <h3 class="text-3xl font-extrabold mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-indigo-100 text-lg max-w-2xl">Selamat datang di pusat kendali event Anda. Berikut adalah ringkasan singkat tentang apa yang terjadi di platform Anda hari ini.</p>
                </div>
                <!-- Dekorasi Background -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 blur-2xl"></div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Stat: Total Events -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="bg-indigo-50 text-indigo-600 w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Event</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $totalEvents }}</h4>
                    </div>
                </div>

                <!-- Stat: Total Pendaftar -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="bg-blue-50 text-blue-600 w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Pendaftar</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $totalPendaftar }}</h4>
                    </div>
                </div>

                <!-- Stat: Menunggu Verifikasi -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="bg-amber-50 text-amber-500 w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 relative">
                        @if($pendingPayments > 0)
                            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
                            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full"></span>
                        @endif
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Menunggu Verifikasi</p>
                        <h4 class="text-2xl font-bold text-gray-900">{{ $pendingPayments }}</h4>
                    </div>
                </div>

                <!-- Stat: Total Pendapatan -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="bg-green-50 text-green-600 w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Pendapatan</p>
                        <h4 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Tabel Pendaftaran Terbaru -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-lg font-bold text-gray-900">Pendaftaran Terbaru</h3>
                            <a href="{{ route('admin.events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Lihat Semua Event &rarr;</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pendaftar</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Event & Tiket</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($recentRegistrations as $reg)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $reg->visitor_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $reg->visitor_email }}</div>
                                            <div class="text-xs text-gray-400 mt-1">{{ $reg->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $reg->event->title }}</div>
                                            <div class="text-sm text-indigo-600">{{ $reg->ticketType->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($reg->status === 'paid' || $reg->status === 'registered')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                    Terverifikasi
                                                </span>
                                            @elseif($reg->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                    Menunggu
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            @endif
                                            
                                            <div class="mt-2">
                                                <a href="{{ route('admin.events.show', $reg->event_id) }}" class="text-xs text-indigo-600 hover:text-indigo-900 hover:underline">Proses Pendaftaran</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                                            Belum ada pendaftaran terbaru.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Info Cepat -->
                <div class="space-y-6">
                    <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100">
                        <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pintasan Cepat
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.events.create') }}" class="block bg-white hover:bg-indigo-600 hover:text-white text-gray-700 rounded-xl p-4 shadow-sm border border-indigo-50 transition duration-300 font-medium">
                                + Buat Event Baru
                            </a>
                            @if(auth()->user()->role === 'superadmin')
                            <a href="{{ route('admin.categories.index') }}" class="block bg-white hover:bg-indigo-600 hover:text-white text-gray-700 rounded-xl p-4 shadow-sm border border-indigo-50 transition duration-300 font-medium">
                                Kategori Event
                            </a>
                            @endif
                            @if(auth()->user()->role === 'superadmin')
                            <a href="{{ route('admin.users.create') }}" class="block bg-white hover:bg-indigo-600 hover:text-white text-gray-700 rounded-xl p-4 shadow-sm border border-indigo-50 transition duration-300 font-medium">
                                + Tambah Panitia
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    @if(auth()->user()->role === 'superadmin')
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="bg-purple-50 text-purple-600 w-12 h-12 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Jumlah Panitia Aktif</p>
                                <h4 class="text-xl font-bold text-gray-900">{{ $totalPanitia }} Akun</h4>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
