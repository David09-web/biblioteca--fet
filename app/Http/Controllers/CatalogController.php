<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('catalog.index', compact('books'));
    }

    public function requestForm(Book $book)
    {
        if ($book->available_copies < 1) {
            return redirect()->route('catalog.index')->with('error', 'El libro no tiene copias disponibles.');
        }
        return view('catalog.request', compact('book'));
    }

    public function storeRequest(Request $request, Book $book)
    {
        if ($book->available_copies < 1) {
            return redirect()->route('catalog.index')->with('error', 'El libro no tiene copias disponibles.');
        }

        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'phone'        => 'required|string|max:30',
            'id_number'    => 'required|string|max:50',
            'carnet_photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $photoPath = $request->file('carnet_photo')->store('carnets', 'public');

        Loan::create([
            'book_id'          => $book->id,
            'student_name'     => $validated['student_name'],
            'phone'            => $validated['phone'],
            'id_number'        => $validated['id_number'],
            'carnet_photo_path'=> $photoPath,
            'checkout_date'    => now(),
            'due_date'         => now()->addMinutes(7),
            'status'           => 'active',
        ]);

        $book->decrement('available_copies');

        return redirect()->route('catalog.index')->with('success', '✅ Préstamo solicitado con éxito. Acércate a la biblioteca para retirar el libro.');
    }
}
