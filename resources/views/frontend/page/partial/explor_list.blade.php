 @if ($places->isNotEmpty())
     <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
         @foreach ($places as $item)
             <a href="{{ route('jelajah.detail', $item->slug) }}">
                 <div class="mb-5 md:mb-0  border rounded-lg shadow-lg hover:shadow-sm transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105"
                     data-category="seluncuran">
                     <div class="mb-5">
                         <img src="{{ $item->getFirstMediaUrl('places-images') }}" alt="{{ $item->title }}"
                             class="w-full h-52 rounded-t-md object-cover" />
                     </div>
                     <div class="mb-5 px-4">
                         <h1 class="text-sm font-semibold text-gray-700">{{ $item->name }}</h1>
                     </div>
                     <div class="mb-5 px-4 text-xs md:text-sm">
                         <div class="flex justify-between border rounded-md shadow-sm py-4 px-6">
                             <div>
                                 <h1 class="text-gray-500 text-xs mb-1 font-semibold">
                                     Jam Oprasional
                                 </h1>
                                 <h1 class="text-gray-700 text-xs font-semibold">
                                     <i class="fa fa-clock text-gray-400"></i> {{ format_jam($item->open) }}
                                     -
                                     {{ format_jam($item->close) }}
                                 </h1>
                             </div>
                             <div>
                                 <h1 class="text-gray-500 text-xs mb-1 font-semibold">
                                     Status
                                 </h1>
                                 <h1 class="text-gray-700 text-xs font-semibold">
                                     @if ($item->is_active == 1)
                                         <i class="fa fa-circle text-green-500"></i> Beroprasi
                                     @else
                                         <i class="fa fa-circle  text-red-500"></i> Maintenace
                                     @endif
                                 </h1>
                             </div>
                         </div>
                     </div>
                 </div>
             </a>
         @endforeach
     </div>
 @else
     <div class="text-center text-gray-500  p-20 rounded-md bg-slate-50">
         <div class="flex justify-center items-center mt-10 mb-5">
             <img src="{{ asset('img/notfon.png') }}" class="w-16" alt="">
         </div>
         <div class="items-center">
             <h1 class="font-semibold">Tidak di temukan!</h1>
         </div>
     </div>
 @endif 

@if ($places->hasPages())
    <div class="mt-6 hover:text-blue-700" id="pagination-links">
        {{ $places->links('pagination::tailwind') }}
    </div>
@endif
