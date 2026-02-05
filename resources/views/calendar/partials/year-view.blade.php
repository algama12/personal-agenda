<div class="p-4">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <template x-for="monthDate in yearMonths" :key="monthDate.getMonth()">
            <div class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow cursor-pointer"
                 @click="goToMonth(monthDate.getMonth())">
                <!-- Month name -->
                <div class="text-center font-semibold text-gray-900 mb-2"
                     :class="monthDate.getMonth() === new Date().getMonth() && currentDate.getFullYear() === new Date().getFullYear() ? 'text-indigo-600' : ''"
                     x-text="getMonthName(monthDate.getMonth())"></div>

                <!-- Mini calendar grid -->
                <div class="grid grid-cols-7 gap-0.5 text-center text-xs">
                    <!-- Day headers -->
                    <template x-for="dayName in ['D', 'L', 'M', 'X', 'J', 'V', 'S']" :key="dayName">
                        <div class="text-gray-400 font-medium" x-text="dayName"></div>
                    </template>

                    <!-- Days -->
                    <template x-for="(day, index) in getMiniMonthDays(monthDate)" :key="index">
                        <div class="py-0.5"
                             :class="{
                                 'text-gray-300': !day,
                                 'bg-indigo-600 text-white rounded': day && isToday(day),
                                 'text-gray-700': day && !isToday(day)
                             }">
                            <span x-text="day ? day.getDate() : ''"></span>
                        </div>
                    </template>
                </div>

                <!-- Event count for month -->
                <div class="mt-2 text-center text-xs text-gray-500"
                     x-show="events.filter(e => new Date(e.start).getMonth() === monthDate.getMonth()).length > 0">
                    <span x-text="events.filter(e => new Date(e.start).getMonth() === monthDate.getMonth()).length"></span>
                    <span>evento(s)</span>
                </div>
            </div>
        </template>
    </div>
</div>
