<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\PublicationTypeController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\FieldDefinitionController;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/search', [SearchController::class, 'search']);

Route::get('/advanced-search', [SearchController::class, 'index']);
Route::get('/advanced-search/results', [SearchController::class, 'advanced_search']);
Route::get('/record/{slug}', [RecordController::class, 'viewResult']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoryController::class);
    Route::get('categories/{category}/children', [CategoryController::class, 'children'])->name('categories.children');
    Route::resource('author', AuthorController::class);
    Route::resource('tags', TagsController::class);
    Route::resource('publications', PublicationController::class);
    Route::resource('publications_types', PublicationTypeController::class)->parameters([
        'publications_types' => 'type'
    ]);
    Route::resource('keywords', KeywordController::class);
    Route::resource('publisher', PublisherController::class);
    Route::resource('custom_fields', FieldDefinitionController::class);
});

Route::get('/test-pdf', function () {
    $parser = new Parser();
    $pdf = $parser->parseFile(public_path('test.pdf'));

    // Extract text from the PDF
    $text = $pdf->getText();

    // Remove line breaks from the text
    $textWithoutBr = nl2br($text);

    return $textWithoutBr;
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
