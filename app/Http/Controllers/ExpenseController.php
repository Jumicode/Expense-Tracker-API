<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
   $expenses = Expense::All();

   $data = [
    'expenses' => $expenses,
    'status' => 200
    ];

 return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:25',
            'description' => 'required|max:500',
            'category' => 'required|max:15',
            'amout' => 'required',
            'date' => 'required|date',
            'custom_date'=> 'date'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error ',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $expenses = Expense::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->caterogy,
            'amout' => $request->amout,
            'date' => $request->date,
            'cusmon_date' => $request->custom_date
        ]);
        if (!$expenses) {
            $data = [
                'message' => 'Error ',
                'status' => 400
            ];
            return response()->json($data, 400);
        }
      
     $data = [
        'expenses' => $expenses,
        'status' => 201
     ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $expenses = Expense::find($id);

        if (!$expenses) {
            $data = [
                'message' => 'Error',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'expenses' => $expenses,
            'status' => 200
        ];
        return response()->json($data, 200); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $expenses = Expense::find($id);
        if (!$expenses) {
            $data = [
                'message' => 'Error',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:25',
            'description' => 'required|max:500',
            'category' => 'required|max:15',
            'amout' => 'required',
            'date' => 'required|date',
            'custom_date'=> 'date'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        
        }     
              $expenses->title = $request->title;
              $expenses->description = $request->description;
              $expenses ->caterogy = $request->category;
              $expenses ->amout = $request->amout;
              $expenses -> date = $request->date;
            $expenses ->custom_date = $request->custom_date;

        $expenses->save();
        
        $data = [
            'message' => 'Success',
            '$expenses' => $expenses,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expenses = Exponse::find($id);
        if (!$expenses) {
            $data = [
                'message' => 'Error',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $expenses->delete();
        $data = [
            'message' => 'Delete',
            'status' => 204
        ];
        return response()->json($data, 204);
    }
    }

