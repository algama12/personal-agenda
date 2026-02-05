<x-app-layout>
    <div class="py-4" x-data="calendarApp()" x-init="init()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Main Calendar Area -->
                <div class="flex-1">
                    <!-- Header with navigation and view switcher -->
                    <div class="bg-white rounded-lg shadow mb-4 p-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <!-- Navigation -->
                            <div class="flex items-center gap-2">
                                <button @click="goToToday()" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Hoy
                                </button>
                                <button @click="navigatePrev()" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button @click="navigateNext()" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                                <h2 class="text-xl font-semibold text-gray-900 ml-2" x-text="headerTitle"></h2>
                            </div>

                            <!-- View Switcher -->
                            <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                                <button @click="changeView('day')" :class="currentView === 'day' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'" class="px-3 py-2 text-sm font-medium">
                                    Dia
                                </button>
                                <button @click="changeView('week')" :class="currentView === 'week' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'" class="px-3 py-2 text-sm font-medium border-l border-gray-300">
                                    Semana
                                </button>
                                <button @click="changeView('month')" :class="currentView === 'month' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'" class="px-3 py-2 text-sm font-medium border-l border-gray-300">
                                    Mes
                                </button>
                                <button @click="changeView('year')" :class="currentView === 'year' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'" class="px-3 py-2 text-sm font-medium border-l border-gray-300">
                                    Ano
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <!-- Day View -->
                        <template x-if="currentView === 'day'">
                            @include('calendar.partials.day-view')
                        </template>

                        <!-- Week View -->
                        <template x-if="currentView === 'week'">
                            @include('calendar.partials.week-view')
                        </template>

                        <!-- Month View -->
                        <template x-if="currentView === 'month'">
                            @include('calendar.partials.month-view')
                        </template>

                        <!-- Year View -->
                        <template x-if="currentView === 'year'">
                            @include('calendar.partials.year-view')
                        </template>
                    </div>
                </div>

                <!-- Notes Sidebar -->
                <div class="w-full lg:w-80">
                    @include('calendar.partials.notes-panel')
                </div>
            </div>
        </div>

        <!-- Event Modal -->
        @include('calendar.partials.event-modal')
    </div>

    @push('scripts')
    <script>
        function calendarApp() {
            return {
                currentView: '{{ $view }}',
                currentDate: new Date('{{ $currentDate->format("Y-m-d") }}'),
                events: [],
                notes: [],
                showEventModal: false,
                editingEvent: null,
                selectedDate: null,
                eventForm: {
                    title: '',
                    description: '',
                    start_datetime: '',
                    end_datetime: '',
                    all_day: false,
                    color: '{{ auth()->user()->avatar_color }}'
                },
                showNoteModal: false,
                editingNote: null,
                noteForm: {
                    title: '',
                    content: '',
                    pinned: false
                },
                colors: ['#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'],

                get headerTitle() {
                    const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                    const days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

                    if (this.currentView === 'day') {
                        return `${days[this.currentDate.getDay()]} ${this.currentDate.getDate()} de ${months[this.currentDate.getMonth()]} ${this.currentDate.getFullYear()}`;
                    } else if (this.currentView === 'week') {
                        const start = this.getWeekStart(this.currentDate);
                        const end = new Date(start);
                        end.setDate(end.getDate() + 6);
                        if (start.getMonth() === end.getMonth()) {
                            return `${start.getDate()} - ${end.getDate()} de ${months[start.getMonth()]} ${start.getFullYear()}`;
                        }
                        return `${start.getDate()} ${months[start.getMonth()]} - ${end.getDate()} ${months[end.getMonth()]} ${start.getFullYear()}`;
                    } else if (this.currentView === 'month') {
                        return `${months[this.currentDate.getMonth()]} ${this.currentDate.getFullYear()}`;
                    } else {
                        return this.currentDate.getFullYear().toString();
                    }
                },

                get monthDays() {
                    const year = this.currentDate.getFullYear();
                    const month = this.currentDate.getMonth();
                    const firstDay = new Date(year, month, 1);
                    const lastDay = new Date(year, month + 1, 0);
                    const days = [];

                    // Previous month days
                    const startDay = firstDay.getDay();
                    const prevMonthLastDay = new Date(year, month, 0).getDate();
                    for (let i = startDay - 1; i >= 0; i--) {
                        days.push({
                            date: new Date(year, month - 1, prevMonthLastDay - i),
                            isCurrentMonth: false
                        });
                    }

                    // Current month days
                    for (let i = 1; i <= lastDay.getDate(); i++) {
                        days.push({
                            date: new Date(year, month, i),
                            isCurrentMonth: true
                        });
                    }

                    // Next month days
                    const remainingDays = 42 - days.length;
                    for (let i = 1; i <= remainingDays; i++) {
                        days.push({
                            date: new Date(year, month + 1, i),
                            isCurrentMonth: false
                        });
                    }

                    return days;
                },

                get weekDays() {
                    const start = this.getWeekStart(this.currentDate);
                    const days = [];
                    for (let i = 0; i < 7; i++) {
                        const date = new Date(start);
                        date.setDate(date.getDate() + i);
                        days.push(date);
                    }
                    return days;
                },

                get hours() {
                    return Array.from({length: 24}, (_, i) => i);
                },

                get yearMonths() {
                    const months = [];
                    for (let i = 0; i < 12; i++) {
                        months.push(new Date(this.currentDate.getFullYear(), i, 1));
                    }
                    return months;
                },

                getWeekStart(date) {
                    const d = new Date(date);
                    const day = d.getDay();
                    d.setDate(d.getDate() - day);
                    return d;
                },

                init() {
                    this.fetchEvents();
                    this.fetchNotes();
                },

                async fetchEvents() {
                    let start, end;
                    if (this.currentView === 'month') {
                        start = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
                        end = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 2, 0);
                    } else if (this.currentView === 'year') {
                        start = new Date(this.currentDate.getFullYear(), 0, 1);
                        end = new Date(this.currentDate.getFullYear(), 11, 31);
                    } else if (this.currentView === 'week') {
                        start = this.getWeekStart(this.currentDate);
                        end = new Date(start);
                        end.setDate(end.getDate() + 7);
                    } else {
                        start = new Date(this.currentDate);
                        start.setHours(0, 0, 0, 0);
                        end = new Date(this.currentDate);
                        end.setHours(23, 59, 59, 999);
                    }

                    const response = await fetch(`/events?start=${start.toISOString()}&end=${end.toISOString()}`);
                    this.events = await response.json();
                },

                async fetchNotes() {
                    const response = await fetch('/notes');
                    this.notes = await response.json();
                },

                changeView(view) {
                    this.currentView = view;
                    this.fetchEvents();
                    this.updateUrl();
                },

                updateUrl() {
                    let url;
                    const date = this.formatDate(this.currentDate);
                    if (this.currentView === 'year') {
                        url = `/calendar/year/${this.currentDate.getFullYear()}`;
                    } else {
                        url = `/calendar/${this.currentView}/${date}`;
                    }
                    history.pushState({}, '', url);
                },

                navigatePrev() {
                    if (this.currentView === 'day') {
                        this.currentDate.setDate(this.currentDate.getDate() - 1);
                    } else if (this.currentView === 'week') {
                        this.currentDate.setDate(this.currentDate.getDate() - 7);
                    } else if (this.currentView === 'month') {
                        this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                    } else {
                        this.currentDate.setFullYear(this.currentDate.getFullYear() - 1);
                    }
                    this.currentDate = new Date(this.currentDate);
                    this.fetchEvents();
                    this.updateUrl();
                },

                navigateNext() {
                    if (this.currentView === 'day') {
                        this.currentDate.setDate(this.currentDate.getDate() + 1);
                    } else if (this.currentView === 'week') {
                        this.currentDate.setDate(this.currentDate.getDate() + 7);
                    } else if (this.currentView === 'month') {
                        this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                    } else {
                        this.currentDate.setFullYear(this.currentDate.getFullYear() + 1);
                    }
                    this.currentDate = new Date(this.currentDate);
                    this.fetchEvents();
                    this.updateUrl();
                },

                goToToday() {
                    this.currentDate = new Date();
                    this.fetchEvents();
                    this.updateUrl();
                },

                goToDate(date) {
                    this.currentDate = new Date(date);
                    this.currentView = 'day';
                    this.fetchEvents();
                    this.updateUrl();
                },

                goToMonth(month) {
                    this.currentDate = new Date(this.currentDate.getFullYear(), month, 1);
                    this.currentView = 'month';
                    this.fetchEvents();
                    this.updateUrl();
                },

                isToday(date) {
                    const today = new Date();
                    return date.getDate() === today.getDate() &&
                           date.getMonth() === today.getMonth() &&
                           date.getFullYear() === today.getFullYear();
                },

                getEventsForDate(date) {
                    const dateStr = this.formatDate(date);
                    return this.events.filter(e => {
                        const eventStart = e.start.split('T')[0];
                        const eventEnd = e.end ? e.end.split('T')[0] : eventStart;
                        return dateStr >= eventStart && dateStr <= eventEnd;
                    });
                },

                getEventsForHour(date, hour) {
                    return this.events.filter(e => {
                        if (e.all_day) return false;
                        const eventDate = new Date(e.start);
                        return this.formatDate(eventDate) === this.formatDate(date) &&
                               eventDate.getHours() === hour;
                    });
                },

                getAllDayEvents(date) {
                    const dateStr = this.formatDate(date);
                    return this.events.filter(e => {
                        if (!e.all_day) return false;
                        const eventStart = e.start.split('T')[0];
                        const eventEnd = e.end ? e.end.split('T')[0] : eventStart;
                        return dateStr >= eventStart && dateStr <= eventEnd;
                    });
                },

                formatDate(date) {
                    return date.toISOString().split('T')[0];
                },

                formatTime(isoString) {
                    const date = new Date(isoString);
                    return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                },

                formatHour(hour) {
                    return hour.toString().padStart(2, '0') + ':00';
                },

                openEventModal(date = null, event = null) {
                    this.selectedDate = date || new Date();
                    if (event) {
                        this.editingEvent = event;
                        this.eventForm = {
                            title: event.title,
                            description: event.description || '',
                            start_datetime: event.start.slice(0, 16),
                            end_datetime: event.end ? event.end.slice(0, 16) : '',
                            all_day: event.all_day,
                            color: event.color
                        };
                    } else {
                        this.editingEvent = null;
                        const dateStr = this.formatDate(this.selectedDate);
                        const now = new Date();
                        const hour = now.getHours().toString().padStart(2, '0');
                        this.eventForm = {
                            title: '',
                            description: '',
                            start_datetime: `${dateStr}T${hour}:00`,
                            end_datetime: '',
                            all_day: false,
                            color: '{{ auth()->user()->avatar_color }}'
                        };
                    }
                    this.showEventModal = true;
                },

                closeEventModal() {
                    this.showEventModal = false;
                    this.editingEvent = null;
                },

                async saveEvent() {
                    const method = this.editingEvent ? 'PUT' : 'POST';
                    const url = this.editingEvent ? `/events/${this.editingEvent.id}` : '/events';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.eventForm)
                    });

                    if (response.ok) {
                        this.closeEventModal();
                        this.fetchEvents();
                    }
                },

                async deleteEvent() {
                    if (!this.editingEvent) return;

                    if (confirm('Estas seguro de eliminar este evento?')) {
                        const response = await fetch(`/events/${this.editingEvent.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            this.closeEventModal();
                            this.fetchEvents();
                        }
                    }
                },

                openNoteModal(note = null) {
                    if (note) {
                        this.editingNote = note;
                        this.noteForm = {
                            title: note.title,
                            content: note.content || '',
                            pinned: note.pinned
                        };
                    } else {
                        this.editingNote = null;
                        this.noteForm = {
                            title: '',
                            content: '',
                            pinned: false
                        };
                    }
                    this.showNoteModal = true;
                },

                closeNoteModal() {
                    this.showNoteModal = false;
                    this.editingNote = null;
                },

                async saveNote() {
                    const method = this.editingNote ? 'PUT' : 'POST';
                    const url = this.editingNote ? `/notes/${this.editingNote.id}` : '/notes';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.noteForm)
                    });

                    if (response.ok) {
                        this.closeNoteModal();
                        this.fetchNotes();
                    }
                },

                async deleteNote() {
                    if (!this.editingNote) return;

                    if (confirm('Estas seguro de eliminar esta nota?')) {
                        const response = await fetch(`/notes/${this.editingNote.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            this.closeNoteModal();
                            this.fetchNotes();
                        }
                    }
                },

                async toggleNotePin(note) {
                    const response = await fetch(`/notes/${note.id}/toggle-pin`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (response.ok) {
                        this.fetchNotes();
                    }
                },

                getMonthName(month) {
                    const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    return months[month];
                },

                getDayName(day) {
                    const days = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
                    return days[day];
                },

                getMiniMonthDays(monthDate) {
                    const year = monthDate.getFullYear();
                    const month = monthDate.getMonth();
                    const firstDay = new Date(year, month, 1);
                    const lastDay = new Date(year, month + 1, 0);
                    const days = [];

                    const startDay = firstDay.getDay();
                    for (let i = 0; i < startDay; i++) {
                        days.push(null);
                    }

                    for (let i = 1; i <= lastDay.getDate(); i++) {
                        days.push(new Date(year, month, i));
                    }

                    return days;
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
