<?php

namespace App\Observers;

use App\Models\Book;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        //
    }

    /**
     * Kezelje a Könyv "frissítve" eseményt.
     *
     * Ez a módszer ellenõrzi, hogy a könyv képe megváltozott-e, és ha igen,
     * naplózza az eseményt, és törli a régi képet, ha létezik.
     *
     * @param Book $book The book that was updated.
     * @return void
     */
    public function updated(Book $book): void
    {
        // Szerezze meg a könyv jelenlegi és eredeti attribútumait
        $currentAttributes = $book->getAttributes();
        $originalAttributes = $book->getOriginalAttributes();

        // Ellenõrizze, hogy a kép megváltozott-e
        $imageChanged = $currentAttributes['image'] !== $originalAttributes['image'];

        if ($imageChanged) {
            // Ellenõrizze, hogy hozzáadtak-e új képet
            $imageAdded = empty($originalAttributes['image']) && !empty($currentAttributes['image']);

            // Ellenõrizze, hogy a képet törölték-e
            $imageDeleted = !empty($originalAttributes['image']) && empty($currentAttributes['image']);

            if ($imageAdded) {
                // Új kép hozzáadásakor naplózza az eseményt
                \Log::info('Képet akarnak feltölteni');
            } elseif ($imageDeleted) {
                // A kép törlésekor naplózza az eseményt
                \Log::info('Törölték a feltöltött képet');
                // Törölje a régi képet
                unlink(public_path($originalAttributes['image']));
            } else {
                // A kép frissítésekor naplózza az eseményt
                \Log::info('Megváltoztatták a képet');
                // Törölje a régi képet
                unlink(public_path($originalAttributes['image']));
            }
        }
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        if( $book->image && file_exists(public_path($book->image)) ) {
            unlink(public_path($book->image));
        }
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        //
    }
}
