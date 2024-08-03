<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pemilihan Karyawan Terbaik PT. Adzkia Masa Depan (Metode Weighted Produk)') }}
        </h2>
    </x-slot>

    @include('weight_product.alternate')
    @include('weight_product.vector_s')
    @include('weight_product.rank')

    <div class="max-w-sm mx-auto">
        <div class="overflow-hidden sm:rounded-lg">
            <div class="p-6 lg:p-8">
                <a href="{{ route('wp.print') }}" target="_BLANK">
                    <x-buttons.primary class="text-xs w-full">
                        {{ __('CETAK HASIL') }}
                    </x-buttons.primary>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
