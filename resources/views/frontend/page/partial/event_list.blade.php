 <div class="grid grid-cols-1 md:grid-cols-3  gap-10 mb-10">
     @forelse ($data_event as $item)
         <div
             class="mb-5 rounded-md shadow-lg hover:shadow-sm transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 flex flex-col justify-between">
             <div class="">
                 <img src="{{ asset('storage/' . $item->thumbail) }}" class="w-full h-96 rounded-t-lg" alt="" />
                 <div class="px-3 py-4 mb-1">
                     <h1 class="text-lg text-center text-gray-700 font-semibold ">
                         {{ $item->title }}
                     </h1>
                 </div>
             </div>
             <div class="px-3 mb-3 mt-auto">
                 <div class="mb-3 ">
                     <h1 class="text-sm py-4 mb-2 text-center font-semibold text-blue-700">
                         <i class="fa fa-calendar"></i> Berlaku Sampai {{ format_tanggal($item->end_date) }}
                     </h1>
                     <a href="{{ route('event.detail', $item->slug) }}"
                         class="w-full flex justify-center text-center  text-sm md:text-base font-semibold text-gray-700 rounded-md border hover:bg-blue-700 hover:text-white py-3 px-3">
                         Cek Sekarang
                     </a>
                 </div>
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
 @if ($data_event->hasPages())
     <div class="mt-6 hover:text-blue-700">
         {{ $data_event->links('pagination::tailwind') }}
     </div>
 @endif
