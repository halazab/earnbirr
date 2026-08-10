@if(session('success'))
    <div id="notif-toast" class="fixed top-24 right-4 sm:right-6 z-[100] max-w-sm w-full bg-white rounded-xl shadow-lg border-l-4 border-emerald-500 p-4 transform transition-all duration-300 translate-x-0">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-emerald-500 text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">Success</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.closest('#notif-toast').remove()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if($errors->any())
    <div id="notif-toast" class="fixed top-24 right-4 sm:right-6 z-[100] max-w-sm w-full bg-white rounded-xl shadow-lg border-l-4 border-red-500 p-4 transform transition-all duration-300 translate-x-0">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">Error</p>
                @foreach($errors->all() as $error)
                    <p class="text-sm text-gray-500 mt-0.5">{{ $error }}</p>
                @endforeach
            </div>
            <button onclick="this.closest('#notif-toast').remove()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif
