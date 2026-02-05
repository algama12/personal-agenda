<!-- Event Modal -->
<div x-show="showEventModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="closeEventModal()"></div>

        <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full mx-auto z-10">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900" x-text="editingEvent ? 'Editar Evento' : 'Nuevo Evento'"></h3>
                <button @click="closeEventModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <div class="p-4 space-y-4">
                <!-- Author info (only when editing) -->
                <div x-show="editingEvent" class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold"
                          :style="editingEvent ? `background-color: ${editingEvent.user.avatar_color}` : ''"
                          x-text="editingEvent ? editingEvent.user.initials : ''"></span>
                    <span class="text-sm text-gray-600">
                        Creado por <span class="font-medium" x-text="editingEvent ? editingEvent.user.name : ''"></span>
                    </span>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titulo</label>
                    <input type="text" x-model="eventForm.title"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="Titulo del evento">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripcion</label>
                    <textarea x-model="eventForm.description" rows="3"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              placeholder="Descripcion opcional"></textarea>
                </div>

                <!-- All day toggle -->
                <div class="flex items-center">
                    <input type="checkbox" x-model="eventForm.all_day" id="all_day"
                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="all_day" class="ml-2 text-sm text-gray-700">Todo el dia</label>
                </div>

                <!-- Date/Time fields -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Inicio</label>
                        <input :type="eventForm.all_day ? 'date' : 'datetime-local'" x-model="eventForm.start_datetime"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fin (opcional)</label>
                        <input :type="eventForm.all_day ? 'date' : 'datetime-local'" x-model="eventForm.end_datetime"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Color picker -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                    <div class="flex gap-2 flex-wrap">
                        <template x-for="color in colors" :key="color">
                            <button type="button"
                                    @click="eventForm.color = color"
                                    class="w-8 h-8 rounded-full border-2 transition-transform hover:scale-110"
                                    :class="eventForm.color === color ? 'border-gray-900 scale-110' : 'border-transparent'"
                                    :style="`background-color: ${color}`"></button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between p-4 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                <div>
                    <button x-show="editingEvent" @click="deleteEvent()" type="button"
                            class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-800">
                        Eliminar
                    </button>
                </div>
                <div class="flex gap-2">
                    <button @click="closeEventModal()" type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button @click="saveEvent()" type="button"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Note Modal -->
<div x-show="showNoteModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="closeNoteModal()"></div>

        <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full mx-auto z-10">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900" x-text="editingNote ? 'Editar Nota' : 'Nueva Nota'"></h3>
                <button @click="closeNoteModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <div class="p-4 space-y-4">
                <!-- Author info (only when editing) -->
                <div x-show="editingNote" class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold"
                          :style="editingNote ? `background-color: ${editingNote.user.avatar_color}` : ''"
                          x-text="editingNote ? editingNote.user.initials : ''"></span>
                    <span class="text-sm text-gray-600">
                        Creado por <span class="font-medium" x-text="editingNote ? editingNote.user.name : ''"></span>
                    </span>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titulo</label>
                    <input type="text" x-model="noteForm.title"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="Titulo de la nota">
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                    <textarea x-model="noteForm.content" rows="5"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              placeholder="Contenido de la nota"></textarea>
                </div>

                <!-- Pinned toggle -->
                <div class="flex items-center">
                    <input type="checkbox" x-model="noteForm.pinned" id="pinned"
                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="pinned" class="ml-2 text-sm text-gray-700">Fijar nota</label>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between p-4 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                <div>
                    <button x-show="editingNote" @click="deleteNote()" type="button"
                            class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-800">
                        Eliminar
                    </button>
                </div>
                <div class="flex gap-2">
                    <button @click="closeNoteModal()" type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button @click="saveNote()" type="button"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
