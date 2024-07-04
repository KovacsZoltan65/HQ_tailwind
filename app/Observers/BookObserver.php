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
     * Kezelje a K�nyv "friss�tve" esem�nyt.
     *
     * Ez a m�dszer ellen�rzi, hogy a k�nyv k�pe megv�ltozott-e, �s ha igen,
     * napl�zza az esem�nyt, �s t�rli a r�gi k�pet, ha l�tezik.
     *
     * @param Book $book The book that was updated.
     * @return void
     */
    public function updated(Book $book): void
    {
        // Szerezze meg a k�nyv jelenlegi �s eredeti attrib�tumait
        $currentAttributes = $book->getAttributes();
        $originalAttributes = $book->getOriginalAttributes();

        // Ellen�rizze, hogy a k�p megv�ltozott-e
        $imageChanged = $currentAttributes['image'] !== $originalAttributes['image'];

        if ($imageChanged) {
            // Ellen�rizze, hogy hozz�adtak-e �j k�pet
            $imageAdded = empty($originalAttributes['image']) && !empty($currentAttributes['image']);

            // Ellen�rizze, hogy a k�pet t�r�lt�k-e
            $imageDeleted = !empty($originalAttributes['image']) && empty($currentAttributes['image']);

            if ($imageAdded) {
                // �j k�p hozz�ad�sakor napl�zza az esem�nyt
                \Log::info('K�pet akarnak felt�lteni');
            } elseif ($imageDeleted) {
                // A k�p t�rl�sekor napl�zza az esem�nyt
                \Log::info('T�r�lt�k a felt�lt�tt k�pet');
                // T�r�lje a r�gi k�pet
                unlink(public_path($originalAttributes['image']));
            } else {
                // A k�p friss�t�sekor napl�zza az esem�nyt
                \Log::info('Megv�ltoztatt�k a k�pet');
                // T�r�lje a r�gi k�pet
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
