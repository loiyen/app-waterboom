 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
     @forelse ($sales as $item)
         <div
             class="wahana mb-5 md:mb-0 w-full md:w-full border rounded-lg shadow-lg hover:shadow-sm transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
             <div class="mb-5 flex justify-center">
                 <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full rounded-t-lg " alt="" />
             </div>
             <div class="mb-5 px-4 flex justify-between items-center">
                 <h1 class="text-base font-semibold text-gray-700">{{ $item->name }}</h1>
                 @if ($item->is_active == 1)
                     <h1 class="text-xs border border-green-500 rounded-md py-1 px-2 text-green-500"><i
                             class="fa fa-check-square"></i> Aktif</h1>
                 @else
                     <h1 class="text-xs border border-red-500 rounded-md py-1 px-2 text-red-500"><i
                             class="fa fa-check-square"></i> Nonaktif</h1>
                 @endif
             </div>
             <div class="px-4 flex justify-center mb-3">
                 <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->Nohp) }}?text={{ urlencode('Halo ' . $item->name . ', Saya ingin reservasi!') }}"
                     target="_blank"
                     class="w-full text-sm text-center font-semibold text-gray-700 rounded-md border hover:bg-green-600 hover:text-white py-3 px-3 transition-all duration-200">
                     <i class="fa-brands fa-whatsapp"></i> Hubungi via WhatsApp
                 </a>
             </div>
         </div>
     @empty
         <div class="col-span-4 text-center text-gray-500  p-20 rounded-md bg-slate-50">
             <div class="flex justify-center items-center mt-10 mb-5">
                 <img src="{{ asset('img/notfon.png') }}" class="w-16" alt="">
             </div>
             <div class="items-center">
                 <h1 class="font-semibold">Tidak di temukan!</h1>
             </div>
         </div>
     @endforelse
 </div>

  @if ($sales->hasPages())
     <div class="mt-6 hover:text-blue-700">
         {{ $sales->links('pagination::tailwind') }}
     </div>
 @endif
