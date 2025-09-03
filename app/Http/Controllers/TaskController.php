<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller; // Ensure correct Controller is imported

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->tasks();

        // Filtrar por estado si se proporciona
        if ($request->has('status') && in_array($request->status, ['pending', 'completed'])) {
            $query->where('status', $request->status);
        }

        // Filtrar tareas eliminadas si se solicita
        if ($request->has('with_trashed') && $request->with_trashed) {
            $query->withTrashed();
        }

        // Filtrar solo tareas eliminadas
        if ($request->has('only_trashed') && $request->only_trashed) {
            $query->onlyTrashed();
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        Auth::user()->tasks()->create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada exitosamente.');
    }

    /**
     * Restore a soft deleted task.
     */
    public function restore($id)
    {
        $task = Auth::user()->tasks()->withTrashed()->findOrFail($id);
        $this->authorize('restore', $task);
        $task->restore();

        return redirect()->route('tasks.index')->with('success', 'Tarea restaurada exitosamente.');
    }

    /**
     * Permanently delete a task.
     */
    public function forceDelete($id)
    {
        $task = Auth::user()->tasks()->withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $task);
        $task->forceDelete();

        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada permanentemente.');
    }

    /**
     * Toggle task status between pending and completed.
     */
    public function toggleStatus(Task $task)
    {
        $this->authorize('update', $task);

        $newStatus = $task->status === 'pending' ? 'completed' : 'pending';
        $task->update(['status' => $newStatus]);

        return back()->with('success', 'Estado de la tarea actualizado.');
    }
}
