 <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
     @csrf
     @method('DELETE')

     <button class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">
         <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round"
                 d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-3h4m-4 0a1 1 0 00-1 1v1h6V5a1 1 0 00-1-1m-4 0h4" />
         </svg>
         Hapus
     </button>

 </form>
