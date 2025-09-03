<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">
                {{ __('Mis Tareas') }}
            </h2>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary hover-scale hover-glow">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nueva Tarea
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="main-container">
                <div class="p-8">
                    
                    <!-- Filtros mejorados -->
                    <div class="mb-8 flex flex-wrap gap-3">
                        <a href="{{ route('tasks.index') }}" 
                           class="filter-tab filter-all {{ !request('status') && !request('only_trashed') ? 'active' : '' }}">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Todas
                        </a>
                        <a href="{{ route('tasks.index', ['status' => 'pending']) }}" 
                           class="filter-tab filter-pending {{ request('status') === 'pending' ? 'active' : '' }}">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pendientes
                        </a>
                        <a href="{{ route('tasks.index', ['status' => 'completed']) }}" 
                           class="filter-tab filter-completed {{ request('status') === 'completed' ? 'active' : '' }}">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Completadas
                        </a>
                        <a href="{{ route('tasks.index', ['only_trashed' => true]) }}" 
                           class="filter-tab filter-deleted {{ request('only_trashed') ? 'active' : '' }}">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminadas
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success fade-in">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($tasks->count() > 0)
                        <div class="space-y-6">
                            @foreach($tasks as $task)
                                <div class="task-card {{ $task->trashed() ? 'task-card-deleted' : ($task->status === 'completed' ? 'task-card-completed' : 'task-card-pending') }} fade-in">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h3 class="task-title {{ $task->status === 'completed' ? 'completed' : '' }}">
                                                    {{ $task->title }}
                                                </h3>
                                                @if($task->description)
                                                    <p class="task-description">{{ $task->description }}</p>
                                                @endif
                                                <div class="task-meta">
                                                    <span class="status-badge {{ $task->trashed() ? 'status-deleted' : ($task->status === 'pending' ? 'status-pending' : 'status-completed') }}">
                                                        @if($task->trashed())
                                                            Eliminada
                                                        @else
                                                            {{ $task->status === 'pending' ? 'Pendiente' : 'Completada' }}
                                                        @endif
                                                    </span>
                                                    @if($task->due_date)
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            Vence: {{ $task->due_date->format('d/m/Y') }}
                                                        </span>
                                                    @endif
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Creada: {{ $task->created_at->format('d/m/Y H:i') }}
                                                    </span>
                                                    @if($task->trashed())
                                                        <span class="text-red-600 dark:text-red-400 flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Eliminada: {{ $task->deleted_at->format('d/m/Y H:i') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="flex flex-col gap-2 ml-6">
                                                @unless($task->trashed())
                                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline text-sm hover-scale">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        Ver
                                                    </a>
                                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning text-sm hover-scale">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Editar
                                                    </a>
                                                    
                                                    <form action="{{ route('tasks.toggle-status', $task) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success text-sm w-full hover-scale">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                @if($task->status === 'pending')
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                @else
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                @endif
                                                            </svg>
                                                            {{ $task->status === 'pending' ? 'Completar' : 'Pendiente' }}
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger text-sm w-full hover-scale">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('tasks.restore', $task->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success text-sm hover-scale">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                            </svg>
                                                            Restaurar
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('tasks.force-delete', $task->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar permanentemente esta tarea?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger text-sm hover-scale">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                            Eliminar Definitivamente
                                                        </button>
                                                    </form>
                                                @endunless
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $tasks->links() }}
                        </div>
                    @else
                        <div class="text-center py-16 fade-in">
                            <div class="mb-6">
                                <svg class="w-24 h-24 mx-auto text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">No hay tareas para mostrar</h3>
                            <p class="text-gray-500 dark:text-gray-500 mb-6">Comienza creando tu primera tarea para organizar tu día</p>
                            @unless(request('only_trashed'))
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary hover-scale hover-glow">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Crear mi primera tarea
                                </a>
                            @endunless
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
