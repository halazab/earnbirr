@if(session('success'))
    <div class="fixed top-4 right-4 z-50 animate-slide-in">
        <div class="bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="fixed top-4 right-4 z-50 animate-slide-in">
        <div class="bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif
@if($errors->any())
    <div class="fixed top-4 right-4 z-50 animate-slide-in">
        <div class="bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg">
            @foreach($errors->all() as $error)
                <div class="flex items-center gap-2"><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif
<style>
@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
@keyframes slideOut {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}
.animate-slide-in { animation: slideIn 0.3s ease-out; }
</style>
<script>
setTimeout(() => {
    document.querySelectorAll('.fixed.top-4.right-4').forEach(el => {
        el.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => el.remove(), 300);
    });
}, 5000);
</script>
