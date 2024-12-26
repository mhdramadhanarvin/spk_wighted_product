<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="grid grid-cols-2 gap-4 p-2">
                    <div class="p-6 lg:p-8 bg-white text-blue-600 border-gray-300 shadow-lg rounded-lg text-center">
                        <h1 class="text-5xl font-bold">{{ $criteria }}</h1>
                        <h1 class="text-xl">Jumlah Kriteria</h1>
                    </div>
                    <div class="p-6 lg:p-8 bg-white text-orange-400 border-gray-300 shadow-lg rounded-lg text-center">
                        <h1 class="text-5xl font-bold">{{ $employee }}</h1>
                        <h1 class="text-xl">Jumlah Karyawan</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
