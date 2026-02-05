<div class="min-h-[600px]">
    <!-- All day events -->
    <div class="border-b border-gray-200 p-2 bg-gray-50" x-show="getAllDayEvents(currentDate).length > 0">
        <div class="text-xs text-gray-500 mb-1">Todo el dia</div>
        <template x-for="event in getAllDayEvents(currentDate)" :key="event.id">
            <div @click="openEventModal(null, event)"
                 class="px-2 py-1 rounded text-sm text-white mb-1 cursor-pointer hover:opacity-80"
                 :style="`background-color: ${event.color}`">
                <div class="flex items-center gap-1">
                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-semibold flex-shrink-0"
                          :style="`background-color: ${event.user.avatar_color}`"
                          x-text="event.user.initials"
                          :title="event.user.name"></span>
                    <span x-text="event.title" class="truncate"></span>
                </div>
            </div>
        </template>
    </div>

    <!-- Time slots -->
    <div class="overflow-y-auto" style="max-height: calc(100vh - 300px);">
        <template x-for="hour in hours" :key="hour">
            <div class="flex border-b border-gray-100 min-h-[60px]">
                <div class="w-16 flex-shrink-0 text-right pr-2 py-1 text-xs text-gray-500 border-r border-gray-200"
                     x-text="formatHour(hour)"></div>
                <div class="flex-1 relative p-1"
                     @click="selectedDate = new Date(currentDate); selectedDate.setHours(hour); openEventModal(selectedDate)">
                    <template x-for="event in getEventsForHour(currentDate, hour)" :key="event.id">
                        <div @click.stop="openEventModal(null, event)"
                             class="absolute left-1 right-1 px-2 py-1 rounded text-sm text-white cursor-pointer hover:opacity-80"
                             :style="`background-color: ${event.color}`">
                            <div class="flex items-center gap-1">
                                <span class="w-4 h-4 rounded-full flex items-center justify-center text-[10px] font-semibold flex-shrink-0"
                                      :style="`background-color: ${event.user.avatar_color}`"
                                      x-text="event.user.initials"
                                      :title="event.user.name"></span>
                                <span x-text="formatTime(event.start)" class="text-xs opacity-80"></span>
                                <span x-text="event.title" class="truncate"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>
