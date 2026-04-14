<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalBooks = Book::sum('total_copies');
        $availableBooks = Book::sum('available_copies');
        $borrowedBooks = $totalBooks - $availableBooks;

        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();

        $activeLoans = Loan::where('status', 'active')->count();
        $overdueLoans = Loan::where('status', 'active')->where('due_date', '<', now())->get();

        return view('reports.index', compact(
            'totalBooks', 'availableBooks', 'borrowedBooks',
            'totalUsers', 'totalStudents', 'totalTeachers',
            'activeLoans', 'overdueLoans'
        ));
    }
}
