<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-12">
                        <div class="col-span-10">
                            <h1 class="text-2xl font-medium text-gray-900">
                                Data Alternatif Karyawan
                            </h1>
                        </div>
                        <div class="col-span-2">
                            <a href="{{ route('employee.create') }}">
                                <x-buttons.primary class="text-xs px-2 ml-5">
                                    {{ __('Tambah Data') }}
                                </x-buttons.primary>
                            </a>
                        </div>
                    </div>


                    <div class="mt-6 text-gray-500">
                        @php
                        $action = ['edit' => 'employee', 'delete' => 'employee'];
                        @endphp
                        <x-table-list :header="$header" :record="$employee" :action="$action" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
