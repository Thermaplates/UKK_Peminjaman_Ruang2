@extends('layout')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                <h2 class="text-2xl font-semibold text-white">
                    Verifikasi Pembayaran
                </h2>
                <p class="mt-2 text-blue-100">
                    Daftar peminjaman yang memerlukan verifikasi pembayaran
                </p>
            </div>

            <div class="p-6">
                <div class="space-y-6">
                    @forelse($peminjaman as $booking)
                        <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $booking->user->name }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $booking->ruang->nama_ruang }} - {{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}
                                        </p>
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                        </p>
                                        <p class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Biaya: Rp {{ number_format($booking->biaya, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <form action="{{ route('pembayaran.verifikasi', $booking->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Verifikasi
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Bukti Pembayaran
                                    </label>
                                    <div class="mt-2">
                                        <img src="data:image/jpeg;base64,{{ base64_encode($booking->bukti_pembayaran) }}" 
                                            alt="Bukti Pembayaran" 
                                            class="max-w-lg rounded-lg shadow-sm cursor-pointer"
                                            onclick="openModal('{{ base64_encode($booking->bukti_pembayaran) }}')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada pembayaran yang perlu diverifikasi</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center">
    <div class="relative">
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-screen rounded-lg">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-white text-2xl">&times;</button>
    </div>
</div>

<script>
    function openModal(imageBase64) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = `data:image/jpeg;base64,${imageBase64}`;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
    }
</script>
@endsection