<div class="py-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                <div class="grid grid-cols-12">
                    <div class="col-span-10">
                        <h1 class="text-2xl font-medium text-gray-900">
                            Nilai Preferensi Perankingan
                        </h1>
                    </div>
                </div>

                <div class="mt-6 text-gray-500">
                    <x-table-list :header="$headerFinal" :record="$final" />
                </div>
            </div>
        </div>
    </div>
</div>
