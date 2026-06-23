<x-public-layout>
    <x-slot name="title">{{ $event->title }} - Eventix</x-slot>
    <x-slot name="metaDescription">{{ Str::limit(strip_tags($event->description), 150) }}</x-slot>
    @if($event->posters->count() > 0)
        <x-slot name="ogImage">{{ asset(Storage::url($event->posters->first()->image_path)) }}</x-slot>
    @endif
    <!-- Event Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row gap-10 items-start">
                @if($event->posters->count() > 0)
                    <div class="w-full md:w-1/3 shrink-0 relative group rounded-2xl shadow-lg overflow-hidden aspect-[4/5]">
                        <div id="carousel" class="flex overflow-x-auto snap-x snap-mandatory h-full w-full [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                            @foreach($event->posters as $poster)
                                <div class="w-full shrink-0 snap-center h-full">
                                    <img src="{{ Storage::url($poster->image_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                        
                        @if($event->posters->count() > 1)
                            <!-- Tombol Geser Kiri -->
                            <button onclick="document.getElementById('carousel').scrollBy({left: -document.getElementById('carousel').offsetWidth, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-[0_2px_8px_rgba(0,0,0,0.15)] text-gray-800 hover:bg-gray-50 transition-all z-10 focus:outline-none" aria-label="Geser Kiri">
                                <svg class="w-5 h-5 ml-[-2px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                            </button>
                            
                            <!-- Tombol Geser Kanan -->
                            <button onclick="document.getElementById('carousel').scrollBy({left: document.getElementById('carousel').offsetWidth, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-[0_2px_8px_rgba(0,0,0,0.15)] text-gray-800 hover:bg-gray-50 transition-all z-10 focus:outline-none" aria-label="Geser Kanan">
                                <svg class="w-5 h-5 mr-[-2px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                            </button>
                            <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 z-10 pointer-events-none">
                                @foreach($event->posters as $index => $poster)
                                    <div class="w-2 h-2 rounded-full bg-white/60 shadow-sm"></div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
                <div class="flex-1">
                    <div class="mb-4">
                        @foreach($event->categories as $category)
                            <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 text-sm font-bold rounded-full mr-2">{{ $category->name }}</span>
                        @endforeach
                    </div>
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-6 leading-tight">{{ $event->title }}</h1>
                    
                    <div class="flex flex-col sm:flex-row gap-6 mb-8">
                        <div class="flex items-start">
                            <div class="bg-gray-50 p-3 rounded-xl mr-4 text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Tanggal & Waktu</p>
                                <p class="text-gray-900 font-semibold">{{ $event->start_date->format('l, d M Y') }}</p>
                                <p class="text-gray-600 mb-1">{{ $event->start_date->format('H:i') }} WIB</p>
                                @if($event->end_date)
                                    <p class="text-xs text-gray-500 font-medium mt-1 border-t pt-1">Sampai:</p>
                                    <p class="text-gray-900 font-semibold">{{ $event->end_date->format('l, d M Y') }}</p>
                                    <p class="text-gray-600">{{ $event->end_date->format('H:i') }} WIB</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-gray-50 p-3 rounded-xl mr-4 text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Lokasi</p>
                                <p class="text-gray-900 font-semibold">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="prose prose-indigo max-w-none text-gray-600 leading-relaxed">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Deskripsi Event</h3>
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" id="registration-section">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Ticket Selection -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilih Tiket</h2>
                <div class="space-y-4">
                    @forelse($event->ticketTypes as $ticket)
                        <label class="block cursor-pointer">
                            <input type="radio" name="selected_ticket" value="{{ $ticket->id }}" class="peer sr-only" onchange="selectTicket(this.value, '{{ $ticket->name }}', {{ $ticket->price }})">
                            <div class="p-6 rounded-2xl border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:border-gray-300 transition-all">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $ticket->name }}</h3>
                                        @if($ticket->valid_date)
                                            <p class="text-xs font-semibold text-indigo-600 mt-1">Berlaku tgl: {{ \Carbon\Carbon::parse($ticket->valid_date)->format('d M Y') }}</p>
                                        @else
                                            <p class="text-xs font-semibold text-indigo-600 mt-1">Berlaku untuk semua hari</p>
                                        @endif
                                        <p class="text-sm text-gray-500 mt-1">Sisa kuota: <span class="font-semibold text-indigo-600">{{ $ticket->quota }}</span></p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xl font-bold text-gray-900">
                                            {{ $ticket->price > 0 ? 'Rp ' . number_format($ticket->price, 0, ',', '.') : 'Gratis' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @empty
                        <div class="bg-yellow-50 text-yellow-800 p-4 rounded-xl text-center">
                            Mohon maaf, tiket belum tersedia atau sudah habis.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Registration Form -->
            <div>
                <div class="bg-white p-8 rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full -mr-16 -mt-16 z-0"></div>
                    <div class="relative z-10">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Formulir Pendaftaran</h2>
                        <p class="text-gray-500 mb-8 text-sm">Isi data diri Anda dengan benar untuk menerima e-ticket.</p>

                        @if($event->ticketTypes->count() > 0)
                            <form action="{{ route('events.register', $event->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="ticket_type_id" id="ticket_type_id" required>
                                
                                <div id="selected-ticket-info" class="hidden mb-6 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                                    <p class="text-sm text-indigo-800 font-medium">Tiket Terpilih:</p>
                                    <p class="text-lg font-bold text-indigo-900"><span id="lbl-ticket-name"></span> - <span id="lbl-ticket-price"></span></p>
                                </div>

                                <div class="space-y-5">
                                    <div>
                                        <label for="visitor_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                        <input type="text" name="visitor_name" id="visitor_name" class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" value="{{ old('visitor_name') }}" required>
                                        @error('visitor_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="visitor_email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                                        <input type="email" name="visitor_email" id="visitor_email" class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" value="{{ old('visitor_email') }}" required>
                                        <p class="text-xs text-gray-500 mt-1">E-ticket akan dikirimkan ke email ini.</p>
                                        @error('visitor_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="visitor_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                                        <input type="text" name="visitor_phone" id="visitor_phone" class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" value="{{ old('visitor_phone') }}" required>
                                        @error('visitor_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    @if(session('error'))
                                        <p class="text-red-500 text-sm bg-red-50 p-3 rounded-lg">{{ session('error') }}</p>
                                    @endif

                                    <button type="submit" id="btn-submit" disabled class="w-full mt-4 bg-gray-300 cursor-not-allowed text-gray-500 font-bold py-4 px-8 rounded-xl transition duration-300 text-lg">
                                        Pilih Tiket Dulu
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-10">
                                <p class="text-gray-500">Pendaftaran ditutup karena tiket belum tersedia.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function selectTicket(id, name, price) {
            document.getElementById('ticket_type_id').value = id;
            document.getElementById('selected-ticket-info').classList.remove('hidden');
            document.getElementById('lbl-ticket-name').innerText = name;
            
            let priceText = price > 0 ? 'Rp ' + parseInt(price).toLocaleString('id-ID') : 'Gratis';
            document.getElementById('lbl-ticket-price').innerText = priceText;

            let btn = document.getElementById('btn-submit');
            btn.disabled = false;
            btn.className = 'w-full mt-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 text-lg transform hover:-translate-y-1';
            btn.innerText = 'Daftar Sekarang';
        }

        // Auto-select if old value exists (validation error case)
        window.onload = function() {
            let oldTicket = "{{ old('ticket_type_id') }}";
            if (oldTicket) {
                let radio = document.querySelector('input[value="'+oldTicket+'"]');
                if(radio) radio.click();
            }
        }
    </script>
    @endpush
</x-public-layout>
