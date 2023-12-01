<?php

namespace App\Http\Controllers;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Book;

use App\Http\Requests\CsvImportRequest;

use Maatwebsite\Excel\Facades\Excel;
class UserController extends Controller
{
    public function search()
    {
        return view('user');
     

    }

    public function autocomplete(Request $request)
    {        
        $data = mangers::select("name")
                ->where("name","LIKE","%{$request->str}%")
                ->get('query');   
        return response()->json($data);
    }
    public function match()
    {
        return view('match');
    }

    public function parseImport(Request $request)
{
   
    $path = $request->file('file')->getRealPath();
    $fileContent = file_get_contents($path); 
   
    $csv_header_fields = [];  
    
    if ($request->has('header')) {
        $data = Excel::load($path, function($reader) {})->get()->toArray();
        foreach ($data[0] as $key => $value) {
            $csv_header_fields[] = $key;
        }
    } else {
        $data = array_map('str_getcsv', file($path));


    }

    if (count($data) > 0) {
        $csv_data = array_slice($data, 0, 2);

        $csv_data_file = Book::create([
            'title' => $request->file('file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),  
            'csv_data' => json_encode($data),
        ]);
    } else {
        return redirect()->back();
    }
   
    return view('import_fields', compact('csv_header_fields', 'csv_data', 'csv_data_file'));
}


public function processImport(Request $request)
{
    $data = Book::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $contact = new Contact();
            foreach (config('app.db_fields') as $index => $field) {
                if ($data->csv_header) {
                    $contact->$field = $row[$request->fields[$field]];
                } else {
                    $contact->$field = $row[$request->fields[$index]];
                }
            }
            $contact->save();
        }


    return redirect()->route('match')->with('success', 'CSV data imported successfully');

}

}