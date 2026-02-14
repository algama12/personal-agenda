<x-app-layout>
    <div class="py-4" x-data="calendarApp()" x-init="init()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Daily Quote -->
            <div class="mb-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg p-4 text-white" x-show="dailyQuote">
                <div class="flex items-start gap-3">
                    <svg class="w-8 h-8 flex-shrink-0 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                    <div>
                        <p class="text-lg font-medium italic" x-text="dailyQuote?.text"></p>
                        <p class="text-sm opacity-80 mt-1" x-text="'— ' + dailyQuote?.author"></p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Main Calendar Area -->
                <div class="flex-1">
                    <!-- Header with navigation and view switcher -->
                    <div class="bg-white rounded-xl shadow-sm mb-4 p-4 border border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <!-- Navigation -->
                            <div class="flex items-center gap-2">
                                <button @click="goToToday()" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                                    Hoy
                                </button>
                                <button @click="navigatePrev()" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button @click="navigateNext()" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                                <h2 class="text-xl font-semibold text-gray-900 ml-2" x-text="headerTitle"></h2>
                            </div>

                            <!-- View Switcher -->
                            <div class="flex bg-gray-100 rounded-lg p-1">
                                <button @click="changeView('day')" :class="currentView === 'day' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">
                                    Día
                                </button>
                                <button @click="changeView('week')" :class="currentView === 'week' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">
                                    Semana
                                </button>
                                <button @click="changeView('month')" :class="currentView === 'month' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">
                                    Mes
                                </button>
                                <button @click="changeView('year')" :class="currentView === 'year' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'" class="px-4 py-2 text-sm font-medium rounded-md transition-all">
                                    Año
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
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

                <!-- Sidebar -->
                <div class="w-full lg:w-80 space-y-4">
                    <!-- Sidebar Tabs -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-1 flex">
                        <button @click="sidebarTab = 'notes'"
                                :class="sidebarTab === 'notes' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900'"
                                class="flex-1 px-3 py-2 text-sm font-medium rounded-lg transition-all flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Notas
                        </button>
                        <button @click="sidebarTab = 'shopping'"
                                :class="sidebarTab === 'shopping' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900'"
                                class="flex-1 px-3 py-2 text-sm font-medium rounded-lg transition-all flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                            </svg>
                            Compra
                        </button>
                    </div>

                    <!-- Notes Panel -->
                    <div x-show="sidebarTab === 'notes'">
                        @include('calendar.partials.notes-panel')
                    </div>

                    <!-- Shopping List Panel -->
                    <div x-show="sidebarTab === 'shopping'">
                        @include('calendar.partials.shopping-panel')
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Modal -->
        @include('calendar.partials.event-modal')

        <!-- Toast Container -->
        <div class="fixed bottom-4 right-4 z-50 space-y-2">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="toast.visible"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border"
                     :class="{
                         'bg-green-50 border-green-200 text-green-800': toast.type === 'success',
                         'bg-red-50 border-red-200 text-red-800': toast.type === 'error',
                         'bg-blue-50 border-blue-200 text-blue-800': toast.type === 'info',
                         'bg-amber-50 border-amber-200 text-amber-800': toast.type === 'warning'
                     }">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <template x-if="toast.type === 'success'">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </template>
                        <template x-if="toast.type === 'error'">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </template>
                        <template x-if="toast.type === 'info'">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </template>
                        <template x-if="toast.type === 'warning'">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </template>
                    </div>
                    <p class="text-sm font-medium" x-text="toast.message"></p>
                    <button @click="removeToast(toast.id)" class="ml-2 flex-shrink-0 opacity-70 hover:opacity-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <!-- Confirm Modal -->
        <div x-show="confirmModal.show"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto"
             style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" @click="confirmModal.show = false; confirmModal.onCancel && confirmModal.onCancel()"></div>

                <div x-show="confirmModal.show"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="relative bg-white rounded-2xl shadow-xl max-w-sm w-full mx-auto z-10 overflow-hidden">

                    <!-- Icon -->
                    <div class="pt-6 pb-4 text-center">
                        <div class="mx-auto w-14 h-14 rounded-full flex items-center justify-center"
                             :class="confirmModal.type === 'danger' ? 'bg-red-100' : 'bg-amber-100'">
                            <svg class="w-7 h-7" :class="confirmModal.type === 'danger' ? 'text-red-600' : 'text-amber-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="px-6 pb-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-900" x-text="confirmModal.title"></h3>
                        <p class="mt-2 text-sm text-gray-500" x-text="confirmModal.message"></p>
                    </div>

                    <!-- Actions -->
                    <div class="flex border-t border-gray-100">
                        <button @click="confirmModal.show = false; confirmModal.onCancel && confirmModal.onCancel()"
                                class="flex-1 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button @click="confirmModal.onConfirm && confirmModal.onConfirm(); confirmModal.show = false"
                                class="flex-1 px-4 py-3 text-sm font-medium border-l border-gray-100 transition-colors"
                                :class="confirmModal.type === 'danger' ? 'text-red-600 hover:bg-red-50' : 'text-amber-600 hover:bg-amber-50'">
                            <span x-text="confirmModal.confirmText || 'Confirmar'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
                shoppingItems: [],
                newShoppingItem: '',
                sidebarTab: 'notes',

                colors: ['#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'],

                // Toast system
                toasts: [],
                toastId: 0,

                // Confirm modal
                confirmModal: {
                    show: false,
                    type: 'danger',
                    title: '',
                    message: '',
                    confirmText: 'Eliminar',
                    onConfirm: null,
                    onCancel: null
                },

                // Daily quote
                dailyQuote: null,
                quotes: [
                    { text: "El unico modo de hacer un gran trabajo es amar lo que haces.", author: "Steve Jobs" },
                    { text: "La vida es lo que pasa mientras estas ocupado haciendo otros planes.", author: "John Lennon" },
                    { text: "El exito es ir de fracaso en fracaso sin perder el entusiasmo.", author: "Winston Churchill" },
                    { text: "No cuentes los dias, haz que los dias cuenten.", author: "Muhammad Ali" },
                    { text: "La mejor manera de predecir el futuro es crearlo.", author: "Peter Drucker" },
                    { text: "El tiempo es lo mas valioso que un hombre puede gastar.", author: "Teofrasto" },
                    { text: "Haz hoy lo que otros no quieren, haz manana lo que otros no pueden.", author: "Jerry Rice" },
                    { text: "La disciplina es el puente entre metas y logros.", author: "Jim Rohn" },
                    { text: "No esperes. El tiempo nunca sera el adecuado.", author: "Napoleon Hill" },
                    { text: "Tu tiempo es limitado, no lo desperdicies viviendo la vida de alguien mas.", author: "Steve Jobs" },
                    { text: "El secreto de salir adelante es empezar.", author: "Mark Twain" },
                    { text: "Cada dia es una nueva oportunidad para cambiar tu vida.", author: "Anónimo" },
                    { text: "La persistencia puede cambiar el fracaso en un logro extraordinario.", author: "Marv Levy" },
                    { text: "Lo que haces hoy puede mejorar todos tus mananas.", author: "Ralph Marston" },
                    { text: "La unica forma de lograr lo imposible es creer que es posible.", author: "Charles Kingsleigh" },
                    { text: "Planifica tu trabajo y trabaja tu plan.", author: "Napoleon Hill" },
                    { text: "El exito no es la clave de la felicidad. La felicidad es la clave del exito.", author: "Albert Schweitzer" },
                    { text: "Nunca es demasiado tarde para ser lo que podrias haber sido.", author: "George Eliot" },
                    { text: "La accion es la llave fundamental de todo exito.", author: "Pablo Picasso" },
                    { text: "Cree que puedes y ya estaras a medio camino.", author: "Theodore Roosevelt" },
                    { text: "Los grandes logros requieren tiempo.", author: "David Joseph Schwartz" },
                    { text: "El mejor momento para plantar un arbol fue hace 20 anos. El segundo mejor momento es ahora.", author: "Proverbio chino" },
                    { text: "La vida comienza al final de tu zona de confort.", author: "Neale Donald Walsch" },
                    { text: "No mires el reloj; haz lo que hace. Sigue adelante.", author: "Sam Levenson" },
                    { text: "El unico limite a nuestros logros de manana son nuestras dudas de hoy.", author: "Franklin D. Roosevelt" },
                    { text: "Trabaja duro en silencio, deja que el exito haga el ruido.", author: "Frank Ocean" },
                    { text: "La motivacion es lo que te pone en marcha, el habito es lo que hace que sigas.", author: "Jim Ryun" },
                    { text: "Si puedes sonarlo, puedes hacerlo.", author: "Walt Disney" },
                    { text: "No tengas miedo de renunciar a lo bueno para ir a por lo grandioso.", author: "John D. Rockefeller" },
                    { text: "El futuro pertenece a quienes creen en la belleza de sus suenos.", author: "Eleanor Roosevelt" },
                    { text: "Cada logro comienza con la decision de intentarlo.", author: "Gail Devers" }
                ],

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

                    const startDay = (firstDay.getDay() + 6) % 7; // Monday = 0
                    const prevMonthLastDay = new Date(year, month, 0).getDate();
                    for (let i = startDay - 1; i >= 0; i--) {
                        days.push({
                            date: new Date(year, month - 1, prevMonthLastDay - i),
                            isCurrentMonth: false
                        });
                    }

                    for (let i = 1; i <= lastDay.getDate(); i++) {
                        days.push({
                            date: new Date(year, month, i),
                            isCurrentMonth: true
                        });
                    }

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
                    const diff = (day === 0) ? -6 : 1 - day;
                    d.setDate(d.getDate() + diff);
                    return d;
                },

                init() {
                    this.fetchEvents();
                    this.fetchNotes();
                    this.fetchShoppingItems();
                    this.loadDailyQuote();
                },

                loadDailyQuote() {
                    const today = new Date();
                    const dayOfYear = Math.floor((today - new Date(today.getFullYear(), 0, 0)) / (1000 * 60 * 60 * 24));
                    const quoteIndex = dayOfYear % this.quotes.length;
                    this.dailyQuote = this.quotes[quoteIndex];
                },

                // Toast methods
                showToast(message, type = 'info') {
                    const id = ++this.toastId;
                    const toast = { id, message, type, visible: true };
                    this.toasts.push(toast);

                    setTimeout(() => {
                        this.removeToast(id);
                    }, 4000);
                },

                removeToast(id) {
                    const index = this.toasts.findIndex(t => t.id === id);
                    if (index > -1) {
                        this.toasts[index].visible = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 200);
                    }
                },

                // Confirm modal method
                showConfirm(options) {
                    return new Promise((resolve) => {
                        this.confirmModal = {
                            show: true,
                            type: options.type || 'danger',
                            title: options.title || 'Confirmar',
                            message: options.message || 'Estas seguro?',
                            confirmText: options.confirmText || 'Confirmar',
                            onConfirm: () => resolve(true),
                            onCancel: () => resolve(false)
                        };
                    });
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
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
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

                    try {
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
                            this.showToast(this.editingEvent ? 'Evento actualizado correctamente' : 'Evento creado correctamente', 'success');
                        } else {
                            this.showToast('Error al guardar el evento', 'error');
                        }
                    } catch (error) {
                        this.showToast('Error de conexion', 'error');
                    }
                },

                async deleteEvent() {
                    if (!this.editingEvent) return;

                    const confirmed = await this.showConfirm({
                        type: 'danger',
                        title: 'Eliminar evento',
                        message: `Vas a eliminar "${this.editingEvent.title}". Esta accion no se puede deshacer.`,
                        confirmText: 'Eliminar'
                    });

                    if (confirmed) {
                        try {
                            const response = await fetch(`/events/${this.editingEvent.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });

                            if (response.ok) {
                                this.closeEventModal();
                                this.fetchEvents();
                                this.showToast('Evento eliminado correctamente', 'success');
                            } else {
                                this.showToast('Error al eliminar el evento', 'error');
                            }
                        } catch (error) {
                            this.showToast('Error de conexion', 'error');
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

                    try {
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
                            this.showToast(this.editingNote ? 'Nota actualizada correctamente' : 'Nota creada correctamente', 'success');
                        } else {
                            this.showToast('Error al guardar la nota', 'error');
                        }
                    } catch (error) {
                        this.showToast('Error de conexion', 'error');
                    }
                },

                async deleteNote() {
                    if (!this.editingNote) return;

                    const confirmed = await this.showConfirm({
                        type: 'danger',
                        title: 'Eliminar nota',
                        message: `Vas a eliminar "${this.editingNote.title}". Esta accion no se puede deshacer.`,
                        confirmText: 'Eliminar'
                    });

                    if (confirmed) {
                        try {
                            const response = await fetch(`/notes/${this.editingNote.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });

                            if (response.ok) {
                                this.closeNoteModal();
                                this.fetchNotes();
                                this.showToast('Nota eliminada correctamente', 'success');
                            } else {
                                this.showToast('Error al eliminar la nota', 'error');
                            }
                        } catch (error) {
                            this.showToast('Error de conexion', 'error');
                        }
                    }
                },

                async toggleNotePin(note) {
                    try {
                        const response = await fetch(`/notes/${note.id}/toggle-pin`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            this.fetchNotes();
                            this.showToast(note.pinned ? 'Nota desfijada' : 'Nota fijada', 'info');
                        }
                    } catch (error) {
                        this.showToast('Error de conexion', 'error');
                    }
                },

                // Shopping list methods
                async fetchShoppingItems() {
                    const response = await fetch('/shopping-items');
                    this.shoppingItems = await response.json();
                },

                async addShoppingItem() {
                    if (!this.newShoppingItem.trim()) return;

                    try {
                        const response = await fetch('/shopping-items', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ name: this.newShoppingItem.trim() })
                        });

                        if (response.ok) {
                            this.newShoppingItem = '';
                            this.fetchShoppingItems();
                        } else {
                            this.showToast('Error al añadir el artículo', 'error');
                        }
                    } catch (error) {
                        this.showToast('Error de conexión', 'error');
                    }
                },

                async toggleShoppingItem(item) {
                    try {
                        const response = await fetch(`/shopping-items/${item.id}/toggle`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            this.fetchShoppingItems();
                        }
                    } catch (error) {
                        this.showToast('Error de conexión', 'error');
                    }
                },

                async deleteShoppingItem(item) {
                    try {
                        const response = await fetch(`/shopping-items/${item.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            this.fetchShoppingItems();
                        }
                    } catch (error) {
                        this.showToast('Error de conexión', 'error');
                    }
                },

                async clearCompletedItems() {
                    const completedCount = this.shoppingItems.filter(i => i.completed).length;
                    if (completedCount === 0) return;

                    const confirmed = await this.showConfirm({
                        type: 'warning',
                        title: 'Limpiar completados',
                        message: `Vas a eliminar ${completedCount} artículo(s) completado(s).`,
                        confirmText: 'Limpiar'
                    });

                    if (confirmed) {
                        try {
                            const response = await fetch('/shopping-items-clear', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });

                            if (response.ok) {
                                this.fetchShoppingItems();
                                this.showToast('Artículos completados eliminados', 'success');
                            }
                        } catch (error) {
                            this.showToast('Error de conexión', 'error');
                        }
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

                    const startDay = (firstDay.getDay() + 6) % 7; // Monday = 0
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
