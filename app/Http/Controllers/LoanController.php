<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->orderBy('created_at', 'desc')->get();
        return view('loans.index', compact('loans'));
    }

    public function store(Request $request, Book $book)
    {
        if ($book->available_copies < 1) {
            return back()->with('error', 'El libro no tiene copias disponibles.');
        }

        // Crear el préstamo
        Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'checkout_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'active',
        ]);

        // Reducir copias disponibles
        $book->decrement('available_copies');

        return redirect()->route('loans.index')->with('success', 'Préstamo registrado exitosamente.');
    }

    public function returnBook(Loan $loan)
    {
        // Solo el bibliotecario puede marcar como devuelto
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($loan->status === 'returned') {
            return back()->with('error', 'Este préstamo ya fue devuelto.');
        }

        $loan->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        $loan->book->increment('available_copies');

        return redirect()->route('loans.index')->with('success', 'Devolución registrada exitosamente.');
    }
}
