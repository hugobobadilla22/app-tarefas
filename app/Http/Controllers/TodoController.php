<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TodoController extends Controller
{

    // Apply auth middleware to all methods, except to index and show
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString());
        // Show only todos associated to the authenticated user or all todos if not authenticated
        $todos = Auth::check() ? Auth::user()->todos()->whereDate('date', $date)->orderBy('time', 'asc')->get() : Todo::all();
        return view('todos.index', compact('todos', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'done' => 'boolean',
            'date' => 'date',
            'time' => 'required|date_format:H:i',
        ]);

        Todo::create([
            'title' => $request->title,
            'done' => $request->done ?? false,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->route('todos.index')->with('success', 'To do criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = Todo::findOrFail($id);
        // Veridy if todo belongs to authenticated user
        if (Auth::check() && $todo->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        return view('todos.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo = Todo::findOrFail($id);
        // Verify if todo belongs to authenticated user
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'done' => 'boolean',
        ]);

        $todo = Todo::findOrFail($id);
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        $todo->update([
            'title' => $request->title,
            'done' => $request->done ?? false,
        ]);

        return redirect()->route('todos.index')->with('success', 'To do atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todo::findOrFail($id);
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'To do removido com sucesso');
    }

    public function toggleDone($id)
    {
        $todo = Todo::findOrFail($id);
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        $todo->done = !$todo->done;
        $todo->save();

        return redirect()->route('todos.index', $id)->with('success', 'Status do To Do alterado com sucesso!');
    }

    
}
