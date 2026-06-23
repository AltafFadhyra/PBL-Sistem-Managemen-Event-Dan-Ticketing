<x-public-layout>
    <div class="py-20 px-4">
        <div class="max-w-2xl mx-auto">
            @if(session('success'))
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Pendaftaran Berhasil!</h1>
                    <p class="text-gray-600 mt-2">Terima kasih, berikut adalah detail e-ticket Anda.</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100 relative">
                <!-- Ticket Notch -->
                <div class="absolute top-1/2 -left-4 w-8 h-8 bg-gray-50 rounded-full transform -translate-y-1/2 border-r border-gray-100"></div>
                <div class="absolute top-1/2 -right-4 w-8 h-8 bg-gray-50 rounded-full transform -translate-y-1/2 border-l border-gray-100"></div>

                <!-- Ticket Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8 text-white text-center rounded-t-3xl border-b-2 border-dashed border-white/30">
                    <p class="text-indigo-100 text-sm font-semibold tracking-widest uppercase mb-1">E-Ticket Event</p>
                    <h2 class="text-2xl font-bold">{{ $registration->event->title }}</h2>
                </div>

                <!-- Ticket Body -->
                <div class="p-8">
                    <div class="flex justify-center mb-8">
                        <!-- Simulated QR Code (For aesthetics) -->
                        <div class="p-2 bg-white rounded-xl shadow-sm border border-gray-100">
                            <div class="grid grid-cols-4 grid-rows-4 gap-1 w-32 h-32">
                                @for($i=0; $i<16; $i++)
                                    <div class="{{ rand(0,1) ? 'bg-indigo-900' : 'bg-transparent' }} rounded-sm"></div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-8">
                        <p class="text-sm text-gray-500 mb-1">Nomor Registrasi</p>
                        <p class="text-3xl font-black text-gray-900 tracking-widest">{{ $registration->registration_number }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-y-6 gap-x-4 text-sm bg-gray-50 p-6 rounded-2xl">
                        <div>
                            <p class="text-gray-500 mb-1">Nama Peserta</p>
                            <p class="font-bold text-gray-900">{{ $registration->visitor_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Jenis Tiket</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $registration->ticketType->name }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Waktu Event</p>
                            <p class="font-bold text-gray-900">
                                {{ $registration->event->start_date->format('d M Y, H:i') }}
                                @if($registration->event->end_date)
                                    <br> s/d <br> {{ $registration->event->end_date->format('d M Y, H:i') }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Lokasi</p>
                            <p class="font-bold text-gray-900">{{ $registration->event->location }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
