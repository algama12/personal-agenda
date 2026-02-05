<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Note;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'Usuario 1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'avatar_color' => '#3B82F6',
        ]);

        $user2 = User::create([
            'name' => 'Usuario 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'avatar_color' => '#EF4444',
        ]);

        $today = Carbon::today();

        Event::create([
            'user_id' => $user1->id,
            'title' => 'Reunión de equipo',
            'description' => 'Reunión semanal del equipo',
            'start_datetime' => $today->copy()->setHour(10)->setMinute(0),
            'end_datetime' => $today->copy()->setHour(11)->setMinute(0),
            'all_day' => false,
            'color' => '#3B82F6',
        ]);

        Event::create([
            'user_id' => $user2->id,
            'title' => 'Cita médica',
            'description' => 'Revisión anual',
            'start_datetime' => $today->copy()->addDays(2)->setHour(15)->setMinute(30),
            'end_datetime' => $today->copy()->addDays(2)->setHour(16)->setMinute(30),
            'all_day' => false,
            'color' => '#EF4444',
        ]);

        Event::create([
            'user_id' => $user1->id,
            'title' => 'Cumpleaños de María',
            'start_datetime' => $today->copy()->addDays(5)->startOfDay(),
            'all_day' => true,
            'color' => '#10B981',
        ]);

        Event::create([
            'user_id' => $user2->id,
            'title' => 'Entrega de proyecto',
            'description' => 'Fecha límite para el proyecto',
            'start_datetime' => $today->copy()->addDays(7)->setHour(18)->setMinute(0),
            'all_day' => false,
            'color' => '#F59E0B',
        ]);

        Note::create([
            'user_id' => $user1->id,
            'title' => 'Lista de compras',
            'content' => "- Leche\n- Pan\n- Huevos\n- Frutas",
            'pinned' => true,
        ]);

        Note::create([
            'user_id' => $user2->id,
            'title' => 'Ideas para el proyecto',
            'content' => "1. Mejorar la interfaz\n2. Añadir más colores\n3. Implementar notificaciones",
            'pinned' => false,
        ]);

        Note::create([
            'user_id' => $user1->id,
            'title' => 'Recordatorio',
            'content' => 'Llamar al dentista para agendar cita',
            'pinned' => false,
        ]);
    }
}
