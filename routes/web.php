<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/index', function () {
    return view('pages.home');
});


Route::get('/property', function () {
    return view('pages.property');
});


Route::get('/propertydetails', function () {
    return view('pages.propertydetails');
});



Route::get('/contact', function () {
    return view('pages.contact');
});



 


Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');




Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');




Route::get('/categoryform', function () {
    return view('back.categoryform');
});






Route::get('/categoriesshow', [CategoryController::class, 'index'])->name('category.index'); // List all categories

Route::post('/cate', [CategoryController::class, 'store'])->name('admin.categories.store'); 

Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('category.update');
 
Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
Route::get('/admin/sliders/create', [SliderController::class, 'create'])->name('sliders.create');
Route::post('sliders/store', [SliderController::class, 'store'])->name('sliders.store');
Route::delete('/admin/sliders/delete/{id}', [SliderController::class, 'destroy'])->name('sliders.delete');

// Property Index (List all properties)
 
Route::get('/propertysss', [PropertyController::class, 'create'])->name('property.create');

Route::post('/property/store', [PropertyController::class, 'store'])->name('property.store');

Route::get('/propertieslist', [PropertyController::class, 'showpropertydata'])->name('property.list');

Route::get('property/{property}', [PropertyController::class, 'show'])->name('property.show');

Route::get('property/{property}/edit', [PropertyController::class, 'edit'])->name('property.edit');

Route::put('property/{property}', [PropertyController::class, 'update'])->name('property.update');

Route::delete('property/{property}', [PropertyController::class, 'destroy'])->name('property.destroy');

Route::get('/properties', [PropertyController::class, 'showpropertylist'])->name('properties.index');
 
Route::get('properties/{id}', [PropertyController::class, 'categoryProperties'])->name('category.properties');

Route::get('/propertyv/{id}', [PropertyController::class, 'showP'])->name('property.view');
 
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');



 

Route::get('/schedule-visit', [VisitController::class, 'create'])->name('visit.create');
Route::post('/schedule-visit', [VisitController::class, 'store'])->name('visit.store');


 Route::get('/visit', [VisitController::class, 'index'])->name('visit.index');

Route::delete('/visit/{visit}', [VisitController::class, 'destroy'])->name('visit.destroy');
Route::get('/citiesform', [CityController::class, 'create'])->name('citiesform');

// Handle form submission (POST)
Route::post('/citiesform', [CityController::class, 'store'])->name('cities.store');
Route::get('/citieslist', [CityController::class, 'index'])->name('cities.index'); // Show form + list

Route::get('/cities/{id}/edit', [CityController::class, 'edit'])->name('cities.edit');
Route::put('/cities/{id}', [CityController::class, 'update'])->name('cities.update');
Route::delete('/cities/{id}', [CityController::class, 'destroy'])->name('cities.destroy');




// Show Edit Form
// Route::get('/property/{property}/edit', [PropertyController::class, 'edit'])->name('property.edit');

// // Update Property
// Route::put('/property/{property}', [PropertyController::class, 'update'])->name('property.update');

// Delete Property
// Route::delete('/property/{id}', [PropertyController::class, 'destroy'])->name('property.destroy');

 

use App\Http\Controllers\AdminController;
 Route::get('/asend-notification', [AdminController::class, 'notificationPage']);

Route::post('/send-notification', [AdminController::class, 'sendNotification'])
    ->name('send.notification');
    Route::post('/save-onesignal-id', [AdminController::class, 'saveOneSignalId']);

// In routes/web.php
 


Auth::routes(
    [
        'login' => false, // disable default login
    ]
);
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

 use App\Models\User;
use App\Models\Property;
use App\Models\Contact;
use App\Models\Contacts;
use App\Models\Visit;

Route::middleware(['auth'])->group(function () {

    Route::get('/master', function () {

        $totalUsers = User::count();
        $totalProperties = Property::count();
        $totalContacts = Contacts::count();
 $todayVisits = Visit::count();

        return view('back.master', compact(
            'totalUsers',
            'totalProperties',
            'totalContacts',
            'todayVisits'
        ));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/user/{id}/profile', [ProfileController::class, 'view'])->name('user.profile');

});


