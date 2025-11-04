<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\IndustryTypeController;
use App\Http\Controllers\ContactTypeController;

Route::get('/', function () {
    return redirect()->route('organizations.index');
});

Route::resource('organizations', OrganizationController::class);
Route::resource('contacts', ContactController::class);
Route::resource('addresses', AddressController::class);

Route::get('contacts-export/{format}', [ContactController::class, 'export'])->name('contacts.export'); // format csv|xls

Route::resource('activity-logs', ActivityLogController::class)->only(['index', 'show']);

Route::resource('industry-types', IndustryTypeController::class)->except(['show']);
Route::resource('contact-types', ContactTypeController::class)->except(['show']);
