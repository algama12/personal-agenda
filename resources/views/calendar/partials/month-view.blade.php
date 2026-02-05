<div>
    <!-- Days of week header -->
    <div class="grid grid-cols-7 border-b border-gray-200 bg-gray-50">
        <template x-for="(dayName, index) in ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']" :key="index">
            <div class="py-2 text-center text-sm font-medium text-gray-700" x-text="dayName"></div>
        </template>
    </div>

    <!-- Calendar grid -->
    <div class="grid grid-cols-7">
        <template x-for="(dayInfo, index) in monthDays" :key="index">
            <div class="min-h-[100px] border-b border-r border-gray-200 p-1"
                 :class="{
                     'bg-gray-50': !dayInfo.isCurrentMonth,
                     'bg-indigo-50': isToday(dayInfo.date)
                 }"
                 @click="openEventModal(dayInfo.date)">
                <!-- Date number -->
                <div class="flex justify-between items-start mb-1">
                    <span class="text-sm font-medium cursor-pointer hover:text-indigo-600"
                          :class="{
                              'text-gray-400': !dayInfo.isCurrentMonth,
                              'text-indigo-600 font-bold': isToday(dayInfo.date),
                              'text-gray-900': dayInfo.isCurrentMonth && !isToday(dayInfo.date)
                          }"
                          @click.stop="goToDate(dayInfo.date)"
                          x-text="dayInfo.date.getDate()"></span>
                </div>

                <!-- Events -->
                <div class="space-y-0.5">
                    <template x-for="(event, eventIndex) in getEventsForDate(dayInfo.date).slice(0, 3)" :key="event.id">
                        <div @click.stop="openEventModal(null, event)"
                             class="px-1 py-0.5 rounded text-xs text-white cursor-pointer hover:opacity-80 truncate"
                             :style="`background-color: ${event.color}`">
                            <div class="flex items-center gap-0.5">
                                <span class="w-3 h-3 rounded-full flex items-center justify-center text-[8px] font-semibold flex-shrink-0"
                                      :style="`background-color: ${event.user.avatar_color}`"
                                      x-text="event.user.initials"
                                      :title="event.user.name"></span>
                                <span x-text="event.all_day ? event.title : formatTime(event.start) + ' ' + event.title" class="truncate"></span>
                            </div>
                        </div>
                    </template>
                    <template x-if="getEventsForDate(dayInfo.date).length > 3">
                        <div class="text-xs text-gray-500 px-1"
                             x-text="`+${getEventsForDate(dayInfo.date).length - 3} mas`"></div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>
