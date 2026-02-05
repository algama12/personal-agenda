<div class="bg-white rounded-lg shadow">
    <!-- Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Notas</h3>
        <button @click="openNoteModal()"
                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-full transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </button>
    </div>

    <!-- Notes list -->
    <div class="divide-y divide-gray-100 max-h-[calc(100vh-300px)] overflow-y-auto">
        <template x-if="notes.length === 0">
            <div class="p-4 text-center text-gray-500 text-sm">
                No hay notas. Crea una nueva nota.
            </div>
        </template>

        <template x-for="note in notes" :key="note.id">
            <div class="p-3 hover:bg-gray-50 cursor-pointer transition-colors"
                 @click="openNoteModal(note)">
                <div class="flex items-start gap-2">
                    <!-- Pin indicator -->
                    <button @click.stop="toggleNotePin(note)"
                            class="mt-0.5 flex-shrink-0"
                            :class="note.pinned ? 'text-amber-500' : 'text-gray-300 hover:text-gray-400'">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3.196 12.87l-.825.483a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.758 0l7.25-4.25a.75.75 0 000-1.294l-.825-.484-5.666 3.322a2.25 2.25 0 01-2.276 0L3.196 12.87z"/>
                            <path d="M3.196 8.87l-.825.483a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.758 0l7.25-4.25a.75.75 0 000-1.294l-.825-.484-5.666 3.322a2.25 2.25 0 01-2.276 0L3.196 8.87z"/>
                            <path d="M10.38 1.103a.75.75 0 00-.76 0l-7.25 4.25a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.76 0l7.25-4.25a.75.75 0 000-1.294l-7.25-4.25z"/>
                        </svg>
                    </button>

                    <div class="flex-1 min-w-0">
                        <!-- Title and author -->
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center text-white text-[10px] font-semibold flex-shrink-0"
                                  :style="`background-color: ${note.user.avatar_color}`"
                                  x-text="note.user.initials"
                                  :title="note.user.name"></span>
                            <h4 class="text-sm font-medium text-gray-900 truncate" x-text="note.title"></h4>
                        </div>

                        <!-- Content preview -->
                        <p class="text-xs text-gray-500 line-clamp-2" x-text="note.content"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
