 <div class="mb-5 text-lg flex items-center gap-3">
    <i class="fa fa-search text-gray-500"></i> <h1 class="text-gray-500">Pencarian Terbaru</h1>
 </div>
 <div class="w-full grid grid-cols-1 md:grid-cols-2 mb-5 gap-5 md:mb-0">
     @forelse ($berita as $item)
         <div class="w-full h-auto mb-8 rounded-md  flex align-center">
             <div class="md:flex">
                 <div class="md:w-80 h-auto overflow-hidden shadow-md relative group">
                     <img src="{{ $item->getFirstMediaUrl('news-images') }}" alt="{{ $item->title }}"
                         alt="{{ $item->title }}"
                         class="w-full h-full object-cover rounded-md transition-transform duration-500 group-hover:scale-110">
                 </div>
                 <div class="w-full md:px-5">
                     <h1 class="text-sm rounded-md text-blue-800 font-semibold mt-4 md:mt-0">{{ $item->kategori }}</h1>
                     <a href="{{ route('detail.blog', $item->slug) }}">
                         <h1 class="hover:text-blue-800 cursor-pointer mt-4 font-semibold text-base text-gray-700">
                             {{ $item->title }}
                         </h1>
                     </a>
                     {{-- <h1 class="leading-normal mt-2 mb-4 text-xs md:text-sm text-justify text-gray-700">
                         {{ $item->summary }}
                     </h1> --}}

                     {{-- <div class="mb-5 items-center flex justify-between text-xs">
                         <div>

                         </div>
                         <div class="flex justify-center text-gray-700 gap-2">
                             <h5 class="text-xs text-center">
                                 <i class="fa fa-user"></i> {{ $item->user->name }}
                             </h5>
                             <h5 class="text-xs text-center">
                                 <i class="fa fa-calendar"></i> {{ format_tanggal($item->created_at) }}
                             </h5>
                         </div>
                     </div> --}}

                 </div>
             </div>
         </div>
     @empty
         <div class="text-center col-span-4 text-gray-500  p-20 rounded-md bg-slate-50">
             <div class="flex justify-center items-center mt-10 mb-5">
                 <img src="{{ asset('img/notfon.png') }}" class="w-16" alt="">
             </div>
             <div class="items-center">
                 <h1 class="font-semibold">Tidak di temukan!</h1>
             </div>
         </div>
     @endforelse

 </div>

 @if ($berita->hasPages())
     <div class="mt-6 hover:text-blue-700">
         {{ $berita->links('pagination::tailwind') }}
     </div>
 @endif
