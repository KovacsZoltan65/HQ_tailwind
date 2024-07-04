<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::query()->paginate(20);
        
        return Inertia::render('Books/BooksList', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request) {
        Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
        ])->validate();
        
        Book::create($request->all());
        
        $this->processImage($request);
        
        return redirect()->back()
            ->with('message', 'Book created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book) {
        Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
        ])->validate();
        
        $book->update($request->all());
        
        $this->processImage($request);
        
        return redirect()->back()
                ->with('message', 'Book updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book) {
        $book->delete();
        
        return redirect()->back()
            ->with('message', 'Book deleted');
    }

    public function upload(Request $request) {
        //
        if( $request->hasFile('imageFilepond') ){
            return $request->file('imageFilepond')
                    ->store('uploads/books', 'public');
        }
        
        return '';
    }
    
    public function uploadRevert(Request $request) {
        if( $image = $request->get('image') ) {
            $path = storage_path('app/public/' . $image);

            if( file_exists($path) ) {
                unlink($path);
            }
        }
    }

    /**
     * Process the image by copying it from the storage to the public folder and then deleting the original file.
     *
     * @param Request $request The HTTP request containing the image to process.
     * @return void
     */
    protected function processImage(Request $request) {
        //
        if( $image = $request->get('image') ) {
            $path = storage_path('app/public/' . $image);
            if( file_exists($path) ) {
                // Copy the file to the public folder
                copy($path, public_path($image));
                // Delete the original file from the storage folder
                unlink($path);
            }
        }
    }
}
