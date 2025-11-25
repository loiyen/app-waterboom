 <div class="w-full flex flex-col mb-5 md:mb-0">

     @forelse ($berita as $item)
         <div class="w-full h-auto mb-5 border rounded-md shadow-md flex align-center">
             <div class="md:flex">
                 <div class="md:w-64 h-auto">
                     <img src="{{ $item->getFirstMediaUrl('news-images') }}" alt="{{ $item->title }}"
                         alt="{{ $item->title }}" class="w-full h-48 object-cover rounded-md">
                 </div>
                 <div class="w-full">
                     <h1 class="px-3 mt-4 font-semibold text-lg text-gray-700">
                         {{ $item->title }}
                     </h1>
                     <h1 class="leading-normal mt-2 mb-4 px-3 text-xs md:text-sm text-justify text-gray-700">
                         {{ $item->summary }}...
                     </h1>
                     <div class="px-3 mb-5 items-center flex justify-between text-xs">
                         <div>
                             <a href="{{ route('detail.blog', $item->slug) }}"
                                 class="text-gray-700 hover:underline hover:text-blue-700">LIhat lebih banyak</a>
                         </div>
                         <div class="flex justify-center text-gray-700 gap-2">
                             <h5 class="text-xs text-center">
                                 <i class="fa fa-user"></i> {{ $item->user->name }}
                             </h5>
                             <h5 class="text-xs text-center">
                                 <i class="fa fa-calendar"></i> {{ format_tanggal($item->created_at) }}
                             </h5>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     @empty
         <div class="text-center text-gray-500  p-20 rounded-md bg-slate-50">
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


