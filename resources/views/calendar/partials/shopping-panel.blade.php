<div class="bg-white rounded-lg shadow">
    <!-- Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Lista de la compra</h3>
        <button @click="clearCompletedItems()"
                x-show="shoppingItems.filter(i => i.completed).length > 0"
                class="text-xs text-gray-500 hover:text-red-600 transition-colors">
            Limpiar tachados
        </button>
    </div>

    <!-- Add item form -->
    <div class="p-3 border-b border-gray-100">
        <form @submit.prevent="addShoppingItem()" class="flex gap-2">
            <input type="text"
                   x-model="newShoppingItem"
                   placeholder="Añadir artículo..."
                   class="flex-1 text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <button type="submit"
                    class="p-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- Items list -->
    <div class="divide-y divide-gray-100 max-h-[calc(100vh-400px)] overflow-y-auto">
        <template x-if="shoppingItems.length === 0">
            <div class="p-4 text-center text-gray-500 text-sm">
                La lista está vacía. Añade artículos arriba.
            </div>
        </template>

        <template x-for="item in shoppingItems" :key="item.id">
            <div class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 group transition-colors">
                <!-- Checkbox -->
                <button @click="toggleShoppingItem(item)"
                        class="flex-shrink-0 w-5 h-5 rounded border-2 flex items-center justify-center transition-colors"
                        :class="item.completed ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-indigo-500'">
                    <svg x-show="item.completed" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>

                <!-- Item name and author -->
                <div class="flex-1 min-w-0 flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full flex items-center justify-center text-white text-[8px] font-semibold flex-shrink-0"
                          :style="`background-color: ${item.user.avatar_color}`"
                          x-text="item.user.initials"
                          :title="item.user.name"></span>
                    <span class="text-sm truncate"
                          :class="item.completed ? 'line-through text-gray-400' : 'text-gray-900'"
                          x-text="item.name"></span>
                </div>

                <!-- Delete button -->
                <button @click="deleteShoppingItem(item)"
                        class="flex-shrink-0 text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    <!-- Counter -->
    <div class="p-3 border-t border-gray-100 text-xs text-gray-500 text-center"
         x-show="shoppingItems.length > 0">
        <span x-text="shoppingItems.filter(i => !i.completed).length"></span> pendiente(s) ·
        <span x-text="shoppingItems.filter(i => i.completed).length"></span> completado(s)
    </div>
</div>
