<x-public-layout>
    <div class="py-20 px-4">
        <div class="max-w-2xl mx-auto">
            @if(session('success'))
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Pendaftaran Tahap 1 Berhasil!</h1>
                    <p class="text-gray-600 mt-2">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100 relative">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8 text-white text-center rounded-t-3xl">
                    <h2 class="text-2xl font-bold mb-1">Selesaikan Pembayaran</h2>
                    <p class="text-indigo-100 text-sm">Nomor Registrasi: {{ $registration->registration_number }}</p>
                </div>

                <div class="p-8">
                    <div class="bg-indigo-50 rounded-2xl p-6 text-center mb-8 border border-indigo-100">
                        <p class="text-gray-500 mb-2">Total yang harus dibayar</p>
                        <h3 class="text-4xl font-black text-indigo-700">Rp {{ number_format($registration->ticketType->price, 0, ',', '.') }}</h3>
                    </div>

                    <div class="mb-8 border-l-4 border-indigo-500 pl-4">
                        <p class="text-sm font-bold text-gray-900 mb-1">Silakan Transfer ke Rekening Berikut:</p>
                        <p class="text-gray-600 text-lg">Bank BCA - <span class="font-bold text-gray-900">1234567890</span></p>
                        <p class="text-gray-500 text-sm">a.n. Panitia Eventix</p>
                    </div>

                    <form action="{{ route('checkout.store', $registration->registration_number) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer</label>
                            
                            @if($registration->payment_proof)
                                <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-xl border border-green-200 text-sm flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Bukti pembayaran sudah diunggah. Menunggu verifikasi admin.
                                </div>
                                <div class="mb-4">
                                    <img src="{{ Storage::url($registration->payment_proof) }}" class="rounded-xl w-full max-w-xs border" alt="Bukti Pembayaran">
                                </div>
                            @endif

                            <input type="file" name="payment_proof" class="w-full text-sm text-gray-500
                                file:mr-4 file:py-3 file:px-4
                                file:rounded-xl file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100 transition
                            " accept="image/*" {{ $registration->payment_proof ? '' : 'required' }}>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                            @error('payment_proof') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            {{ $registration->payment_proof ? 'Upload Ulang Bukti' : 'Konfirmasi Pembayaran' }}
                        </button>
                    </form>
                    
                    <!-- Batal Pendaftaran -->
                    <form action="{{ route('checkout.destroy', $registration->registration_number) }}" method="POST" class="mt-4" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini? Kuota tiket akan dikembalikan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-transparent hover:bg-red-50 text-red-600 font-medium py-3 px-8 rounded-xl transition duration-300">
                            Batalkan Pendaftaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
