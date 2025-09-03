<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('tasks.index') }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">
                {{ __('Detalle de Tarea') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="main-container">
                <div class="p-8">
                    
                    <!-- Tarjeta principal de la tarea -->
                    <div class="task-card {{ $task->status === 'completed' ? 'task-card-completed' : 'task-card-pending' }} fade-in mb-8">
                        <div class="p-8">
                            <div class="flex justify-between items-start mb-6">
                                <h1 class="task-title {{ $task->status === 'completed' ? 'completed' : '' }}">
                                    {{ $task->title }}
                                </h1>
                                <span class="status-badge {{ $task->status === 'pending' ? 'status-pending' : 'status-completed' }}">
                                    @if($task->status === 'pending')
                                        🕒 Pendiente
                                    @else
                                        ✅ Completada
                                    @endif
                                </span>
                            </div>

                            @if($task->description)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Descripción
                                    </h3>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $task->description }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Información adicional -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                @if($task->due_date)
                                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-4">
                                        <h4 class="font-semibold text-blue-900 dark:text-blue-300 mb-2 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Fecha de Vencimiento
                                        </h4>
                                        <p class="text-blue-800 dark:text-blue-300 font-medium">
                                            {{ $task->due_date->format('d/m/Y') }}
                                            <span class="text-sm text-blue-600 dark:text-blue-400">
                                                ({{ $task->due_date->diffForHumans() }})
                                            </span>
                                        </p>
                                    </div>
                                @endif

                                <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-4">
                                    <h4 class="font-semibold text-green-900 dark:text-green-300 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Fecha de Creación
                                    </h4>
                                    <p class="text-green-800 dark:text-green-300 font-medium">
                                        {{ $task->created_at->format('d/m/Y H:i') }}
                                        <span class="text-sm text-green-600 dark:text-green-400">
                                            ({{ $task->created_at->diffForHumans() }})
                                        </span>
                                    </p>
                                </div>

                                @if($task->updated_at && $task->updated_at != $task->created_at)
                                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-lg p-4">
                                        <h4 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-2 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Última Actualización
                                        </h4>
                                        <p class="text-yellow-800 dark:text-yellow-300 font-medium">
                                            {{ $task->updated_at->format('d/m/Y H:i') }}
                                            <span class="text-sm text-yellow-600 dark:text-yellow-400">
                                                ({{ $task->updated_at->diffForHumans() }})
                                            </span>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex flex-wrap gap-3 justify-between items-center">
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline hover-scale">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                                </svg>
                                Volver a la lista
                            </a>

                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning hover-scale">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar tarea
                            </a>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <form action="{{ route('tasks.toggle-status', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success hover-scale">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($task->status === 'pending')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        @endif
                                    </svg>
                                    {{ $task->status === 'pending' ? 'Marcar como completada' : 'Marcar como pendiente' }}
                                </button>
                            </form>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger hover-scale">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar tarea
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
