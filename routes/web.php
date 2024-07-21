<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\PublicationTypeController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\FieldDefinitionController;
use \App\Http\Controllers\BrowseController;

use Smalot\PdfParser\Parser;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'search']);

Route::get('/advanced-search', [SearchController::class, 'index'])->name('advanced-search');
Route::get('/advanced-search/results', [SearchController::class, 'advanced_search']);
Route::get('/record/{slug}', [RecordController::class, 'viewResult']);
Route::get('/browse', [BrowseController::class,'index'])->name('browse.index');
Route::get('/browse/keywords', [BrowseController::class, 'keywords'])->name('browse.keywords');
Route::get('/browse/keywords/{slug}', [BrowseController::class, 'publicationsByKeyword'])->name('browse.publicationsByKeyword');
Route::get('/browse/authors', [BrowseController::class, 'authors'])->name('browse.authors');
Route::get('/browse/authors/{id}', [BrowseController::class, 'publicationsByAuthor'])->name('browse.publicationsByAuthor');
Route::get('/browse/publishers', [BrowseController::class, 'publishers'])->name('browse.publishers');
Route::get('/browse/publishers/{id}', [BrowseController::class, 'publicationsByPublisher'])->name('browse.publicationsByPublisher');
Route::get('/browse/collections', [BrowseController::class, 'collections'])->name('browse.collections');
Route::get('/browse/collections/{slug}', [BrowseController::class, 'childCollections'])->name('browse.childCollections');
Route::get('/browse/collections/{slug}/publications', [BrowseController::class, 'publicationsByCollection'])->name('browse.publicationsByCollection');
Route::get('/browse/years', [BrowseController::class, 'years'])->name('browse.years');
Route::get('/browse/years/{year}', [BrowseController::class, 'publicationsByYear']);
Route::get('/browse/types', [BrowseController::class, 'types'])->name('browse.types');
Route::get('/browse/types/{id}', [BrowseController::class, 'publicationsByType'])->name('browse.publicationsByType');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('collections', CollectionController::class);
    Route::get('collections/{collection}/children', [CollectionController::class, 'children'])->name('collections.children');
    Route::resource('author', AuthorController::class);
    Route::resource('publications', PublicationController::class);
    Route::resource('publications_types', PublicationTypeController::class)->parameters([
        'publications_types' => 'type'
    ]);
    Route::resource('keywords', KeywordController::class);
    Route::resource('publisher', PublisherController::class);
    Route::resource('custom_fields', FieldDefinitionController::class);
});


// useless routes
// Just to demo sidebar dropdown links active states.
Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';
