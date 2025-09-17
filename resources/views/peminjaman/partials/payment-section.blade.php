<!-- Payment Section -->
<div class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Pembayaran</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Rincian Biaya</h4>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-500 dark:text-gray-400">Biaya per jam:</span>
                            <span class="font-medium text-gray-900 dark:text-white">Rp 50.000</span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            *Termasuk fasilitas ruangan dan peralatan dasar
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-500 dark:text-gray-400">Durasi:</span>
                            <span class="font-medium text-gray-900 dark:text-white" id="durasi">-</span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            *Tidak termasuk jam istirahat (12:00-13:00)
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex justify-between items-baseline">
                            <span class="font-medium text-gray-900 dark:text-white">Total Biaya:</span>
                            <div class="text-right">
                                <span class="block font-bold text-lg text-gray-900 dark:text-white" id="totalBiaya">Rp 0</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    *Harga sudah termasuk pajak
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Upload Bukti Pembayaran
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="bukti_pembayaran" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none">
                                <span>Upload bukti pembayaran</span>
                                <input id="bukti_pembayaran" name="bukti_pembayaran" type="file" class="sr-only" accept="image/*">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <div class="mb-4 text-center">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Scan QRIS untuk Pembayaran</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Silakan scan kode QR berikut untuk melakukan pembayaran</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <img src="{{ asset('img/qris.png') }}" alt="QRIS Code" class="w-48 h-48 object-contain">
            </div>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">Setelah melakukan pembayaran, silakan upload bukti pembayaran</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jamMulaiInput = document.querySelector('input[name="jam_mulai"]');
    const jamSelesaiInput = document.querySelector('input[name="jam_selesai"]');
    const durasiElement = document.getElementById('durasi');
    const totalBiayaElement = document.getElementById('totalBiaya');
    const BIAYA_PER_JAM = 50000;

    function calculateDuration(startTime, endTime) {
        const mulai = new Date(`2000-01-01T${startTime}`);
        const selesai = new Date(`2000-01-01T${endTime}`);
        
        // Jika waktu selesai lebih kecil dari waktu mulai, berarti melewati tengah malam
        if (selesai < mulai) {
            selesai.setDate(selesai.getDate() + 1);
        }

        // Hitung durasi dalam milidetik dan konversi ke jam
        let durasiJam = (selesai - mulai) / (1000 * 60 * 60);

        // Kurangi waktu istirahat (12:00-13:00) jika peminjaman melewati jam tersebut
        const mulaiHour = mulai.getHours();
        const selesaiHour = selesai.getHours();
        
        if (mulaiHour < 13 && selesaiHour >= 13) {
            durasiJam -= 1; // Kurangi 1 jam untuk waktu istirahat
        }

        return Math.max(0, Math.ceil(durasiJam));
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(angka);
    }

    function validateTimeRange() {
        if (!jamMulaiInput.value || !jamSelesaiInput.value) return false;

        const mulaiHour = parseInt(jamMulaiInput.value.split(':')[0]);
        const selesaiHour = parseInt(jamSelesaiInput.value.split(':')[0]);

        // Validasi jam operasional (08:00-17:00)
        if (mulaiHour < 8 || mulaiHour >= 17 || selesaiHour < 8 || selesaiHour > 17) {
            alert('Jam operasional ruangan adalah 08:00-17:00');
            return false;
        }

        // Validasi waktu istirahat
        if ((mulaiHour === 12) || (selesaiHour === 12)) {
            alert('Tidak dapat meminjam pada jam istirahat (12:00-13:00)');
            return false;
        }

        return true;
    }

    function updateBiaya() {
        if (!jamMulaiInput.value || !jamSelesaiInput.value) {
            durasiElement.textContent = '-';
            totalBiayaElement.textContent = formatRupiah(0);
            return;
        }

        if (!validateTimeRange()) {
            jamMulaiInput.value = '';
            jamSelesaiInput.value = '';
            return;
        }

        const durasi = calculateDuration(jamMulaiInput.value, jamSelesaiInput.value);
        
        if (durasi > 0) {
            const biaya = durasi * BIAYA_PER_JAM;
            durasiElement.textContent = `${durasi} jam`;
            totalBiayaElement.textContent = formatRupiah(biaya);

            // Validasi maksimal peminjaman
            if (durasi > 8) {
                alert('Maksimal peminjaman adalah 8 jam per hari');
                jamSelesaiInput.value = '';
                updateBiaya();
            }
        } else {
            durasiElement.textContent = '-';
            totalBiayaElement.textContent = formatRupiah(0);
            
            if (jamMulaiInput.value && jamSelesaiInput.value) {
                alert('Waktu selesai harus lebih besar dari waktu mulai');
                jamSelesaiInput.value = '';
            }
        }
    }

    // Event Listeners
    jamMulaiInput.addEventListener('change', updateBiaya);
    jamSelesaiInput.addEventListener('change', updateBiaya);

    // Preview uploaded image
    const input = document.getElementById('bukti_pembayaran');
    input.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.classList.add('mt-2', 'rounded-lg', 'max-h-48', 'mx-auto');
                
                const container = input.closest('div').querySelector('img');
                if (container) {
                    container.replaceWith(preview);
                } else {
                    input.closest('div').appendChild(preview);
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
});
</script>
@endpush