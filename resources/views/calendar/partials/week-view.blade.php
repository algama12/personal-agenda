<div class="min-h-[600px]">
    <!-- Week header -->
    <div class="grid grid-cols-8 border-b border-gray-200">
        <div class="w-16 flex-shrink-0"></div>
        <template x-for="day in weekDays" :key="day.toISOString()">
            <div class="text-center py-2 border-l border-gray-200"
                 :class="isToday(day) ? 'bg-indigo-50' : ''">
                <div class="text-xs text-gray-500" x-text="getDayName(day.getDay())"></div>
                <div class="text-lg font-semibold"
                     :class="isToday(day) ? 'text-indigo-600' : 'text-gray-900'"
                     x-text="day.getDate()"></div>
            </div>
        </template>
    </div>

    <!-- All day events row -->
    <div class="grid grid-cols-8 border-b border-gray-200 bg-gray-50 min-h-[40px]">
        <div class="w-16 flex-shrink-0 text-right pr-2 py-1 text-xs text-gray-500">
            Todo el dia
        </div>
        <template x-for="day in weekDays" :key="day.toISOString()">
            <div class="border-l border-gray-200 p-1">
                <template x-for="event in getAllDayEvents(day)" :key="event.id">
                    <div @click="openEventModal(null, event)"
                         class="px-1 py-0.5 rounded text-xs text-white mb-0.5 cursor-pointer hover:opacity-80 truncate"
                         :style="`background-color: ${event.color}`"
                         x-text="event.title"
                         :title="event.title + ' - ' + event.user.name"></div>
                </template>
            </div>
        </template>
    </div>

    <!-- Time slots -->
    <div class="overflow-y-auto" style="max-height: calc(100vh - 350px);">
        <template x-for="hour in hours" :key="hour">
            <div class="grid grid-cols-8 border-b border-gray-100 min-h-[48px]">
                <div class="w-16 flex-shrink-0 text-right pr-2 py-1 text-xs text-gray-500"
                     x-text="formatHour(hour)"></div>
                <template x-for="day in weekDays" :key="day.toISOString() + hour">
                    <div class="border-l border-gray-200 p-0.5 relative"
                         :class="isToday(day) ? 'bg-indigo-50/30' : ''"
                         @click="let d = new Date(day); d.setHours(hour); openEventModal(d)">
                        <template x-for="event in getEventsForHour(day, hour)" :key="event.id">
                            <div @click.stop="openEventModal(null, event)"
                                 class="px-1 py-0.5 rounded text-xs text-white cursor-pointer hover:opacity-80 mb-0.5"
                                 :style="`background-color: ${event.color}`">
                                <div class="flex items-center gap-0.5">
                                    <span class="w-3 h-3 rounded-full flex items-center justify-center text-[8px] font-semibold flex-shrink-0"
                                          :style="`background-color: ${event.user.avatar_color}`"
                                          x-text="event.user.initials"></span>
                                    <span x-text="event.title" class="truncate"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>
