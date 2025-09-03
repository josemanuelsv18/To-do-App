<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un usuario de prueba si no existe
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Usuario de Prueba',
                'password' => bcrypt('password')
            ]
        );

        // Crear tareas de ejemplo
        $tasks = [
            [
                'title' => 'Comprar comestibles',
                'description' => 'Necesito comprar leche, pan, huevos y frutas para la semana.',
                'status' => 'pending',
                'due_date' => now()->addDays(2),
            ],
            [
                'title' => 'Llamar al dentista',
                'description' => 'Agendar cita para limpieza dental.',
                'status' => 'pending',
                'due_date' => now()->addDays(1),
            ],
            [
                'title' => 'Completar proyecto Laravel',
                'description' => 'Terminar la aplicación de tareas con todas las funcionalidades.',
                'status' => 'completed',
                'due_date' => now()->subDays(1),
            ],
            [
                'title' => 'Hacer ejercicio',
                'description' => 'Rutina de 30 minutos de cardio.',
                'status' => 'pending',
                'due_date' => now(),
            ],
            [
                'title' => 'Leer libro de programación',
                'description' => 'Continuar leyendo "Clean Code" de Robert C. Martin.',
                'status' => 'pending',
                'due_date' => null,
            ],
            [
                'title' => 'Pagar facturas',
                'description' => 'Pagar electricidad, agua y teléfono.',
                'status' => 'completed',
                'due_date' => now()->subDays(3),
            ],
        ];

        foreach ($tasks as $taskData) {
            $user->tasks()->create($taskData);
        }

        // Crear una tarea eliminada (soft deleted)
        $deletedTask = $user->tasks()->create([
            'title' => 'Tarea eliminada de prueba',
            'description' => 'Esta tarea fue eliminada para probar el soft delete.',
            'status' => 'pending',
            'due_date' => now()->addDays(5),
        ]);
        
        $deletedTask->delete();
    }
}
