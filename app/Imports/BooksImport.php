<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Book;

class BooksImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Process each row, and you can access the data using $row['column_name']
            // Example: Create a new Book instance and save it to the database
            Book::create([
                'title' => $row['title'],
                'author' => $row['author'],
                // Add other columns as needed
            ]);
        }
    }
}
