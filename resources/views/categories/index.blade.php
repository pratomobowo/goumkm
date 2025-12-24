<x-app-layout>
    <x-slot name="header">
        Kategori
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Daftar Kategori</h2>
                <p class="text-sm text-gray-500">Kelola kategori transaksi</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Income Categories -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    Kategori Pemasukan
                </h3>
                <div class="space-y-2">
                    @foreach($categories->where('type', 'income') as $cat)
                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">{{ $cat->name }}</span>
                            @if(!$cat->is_system)
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400">Sistem</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Expense Categories -->
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    Kategori Pengeluaran
                </h3>
                <div class="space-y-2">
                    @foreach($categories->where('type', 'expense') as $cat)
                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">{{ $cat->name }}</span>
                            @if(!$cat->is_system)
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400">Sistem</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Add New Category -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambah Kategori Baru</h3>
            <form action="{{ route('categories.store') }}" method="POST" class="flex gap-4 items-end">
                @csrf
                <div class="flex-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" id="name" name="name" required placeholder="Nama kategori baru"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <select id="type" name="type" class="px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">
                    Tambah
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
