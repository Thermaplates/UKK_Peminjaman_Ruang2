@extends('layout')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                Kelola Ruangan
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Tambah dan kelola ruangan yang tersedia untuk peminjaman
            </p>
        </div>

        <!-- Add Room Form Card -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden mb-8 transform transition-all hover:scale-[1.01]">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Tambah Ruangan Baru</h3>
                <form method="POST" action="/ruang" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <!-- Nama Ruang Field -->
                        <div>
                            <label for="nama_ruang" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nama Ruang
                            </label>
                            <input type="text" name="nama_ruang" id="nama_ruang" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white 
                                transition-colors duration-200"
                                placeholder="Contoh: Ruang Rapat A">
                        </div>

                        <!-- Deskripsi Field -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Deskripsi
                            </label>
                            <input type="text" name="deskripsi" id="deskripsi" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white 
                                transition-colors duration-200"
                                placeholder="Deskripsi singkat ruangan">
                        </div>

                        <!-- Kapasitas Field -->
                        <div>
                            <label for="kapasitas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Kapasitas
                            </label>
                            <input type="number" name="kapasitas" id="kapasitas" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white 
                                transition-colors duration-200"
                                placeholder="Jumlah orang">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" 
                            class="w-full sm:w-auto px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white 
                            bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                            transform hover:scale-[1.02] transition-all duration-200">
                            Tambah Ruangan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Room List Card -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nama Ruang
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Kapasitas
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($ruang as $r)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $r->nama_ruang }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $r->deskripsi }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $r->kapasitas }} Orang
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <form method="POST" action="/ruang/{{ $r->id }}" 
                                    onsubmit="return confirm('Yakin hapus ruang ini? Semua booking juga akan terhapus!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 
                                        transition-colors duration-200 flex items-center gap-1">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
