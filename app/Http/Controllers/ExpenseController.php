<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpenseController extends Controller
{
   
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:Groceries,Leisure,Electronics,Utilities,Clothing,Health,Others',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $expense = Expense::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json($expense, 201);
    }

  
    public function index(Request $request)
    {
        $query = Expense::where('user_id', Auth::id());

       
        if ($request->has('filter')) {
            $filter = $request->filter;

            switch ($filter) {
                case 'last_week':
                    $query->where('date', '>=', Carbon::now()->subWeek());
                    break;
                case 'last_month':
                    $query->where('date', '>=', Carbon::now()->subMonth());
                    break;
                case 'last_3_months':
                    $query->where('date', '>=', Carbon::now()->subMonths(3));
                    break;
            }
        }

      
        if ($request->has(['start_date', 'end_date'])) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $expenses = $query->get();
        return response()->json($expenses);
    }

 
    public function update(Request $request, $id)
    {
        $expense = Expense::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'category' => 'required|string|in:Groceries,Leisure,Electronics,Utilities,Clothing,Health,Others',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $expense->update($request->all());
        return response()->json($expense);
    }

    
    public function destroy($id)
    {
        $expense = Expense::where('user_id', Auth::id())->findOrFail($id);
        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully']);
    }
}


