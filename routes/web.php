<?php

use App\Livewire\Dashboard;
use App\Livewire\Settings\Password;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::post('upload-file', [App\Http\Controllers\API\UserAPIController::class, 'uploadFile'])->name('uploadFile');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // Settings
    Route::get('settings/password', Password::class)->name('settings.password');

    Route::get('email-format', App\Livewire\EmailFormat\Edit::class)->name('email-format');
    Route::get('email-templates', App\Livewire\EmailTemplate\Index::class)->name('email-template.index');
    Route::get('email-template/{id}/edit', App\Livewire\EmailTemplate\Edit::class)->name('email-template.edit');

    // Permission Management
    Route::get('permission', App\Livewire\Permission\Edit::class)->name('permission');

    /* Admin - Role Module */
    Route::get('/role', App\Livewire\Role\Index::class)->name('role.index'); // Role Listing
    Route::get('/role-imports', App\Livewire\Role\Import\IndexImport::class)->name('role.imports'); // Import history

    /* Admin - User Module */
    Route::get('/user', App\Livewire\User\Index::class)->name('user.index'); // User Listing
    Route::get('/user/create', App\Livewire\User\Create::class)->name('user.create'); // Create User
    Route::get('/user/{id}/edit', App\Livewire\User\Edit::class)->name('user.edit'); // Edit User
    /* Admin - FuelConfig Module */
    Route::get('/fuel-config', App\Livewire\FuelConfig\Index::class)->name('fuel-config.index'); // FuelConfig Listing
    Route::get('/fuel-config/create', App\Livewire\FuelConfig\Create::class)->name('fuel-config.create'); // Create FuelConfig
    Route::get('/fuel-config/{id}/edit', App\Livewire\FuelConfig\Edit::class)->name('fuel-config.edit'); // Edit FuelConfig
    /* Admin - Product Module */
    Route::get('/product', App\Livewire\Product\Index::class)->name('product.index'); // Product Listing
    Route::get('/product/create', App\Livewire\Product\Create::class)->name('product.create'); // Create Product
    Route::get('/product/{id}/edit', App\Livewire\Product\Edit::class)->name('product.edit'); // Edit Product
    /* Admin - Dispenser Module */
    Route::get('/dispenser', App\Livewire\Dispenser\Index::class)->name('dispenser.index'); // Dispenser Listing
    Route::get('/dispenser/create', App\Livewire\Dispenser\Create::class)->name('dispenser.create'); // Create Dispenser
    Route::get('/dispenser/{id}/edit', App\Livewire\Dispenser\Edit::class)->name('dispenser.edit'); // Edit Dispenser
    /* Admin - Vehicle Module */
    Route::get('/vehicle', App\Livewire\Vehicle\Index::class)->name('vehicle.index'); // Vehicle Listing
    Route::get('/vehicle/create', App\Livewire\Vehicle\Create::class)->name('vehicle.create'); // Create Vehicle
    Route::get('/vehicle/{id}/edit', App\Livewire\Vehicle\Edit::class)->name('vehicle.edit'); // Edit Vehicle
    /* Admin - Organization Module */
    Route::get('/organization', App\Livewire\Organization\Index::class)->name('organization.index'); // Organization Listing
    Route::get('/organization/create', App\Livewire\Organization\Create::class)->name('organization.create'); // Create Organization
    Route::get('/organization/{id}/edit', App\Livewire\Organization\Edit::class)->name('organization.edit'); // Edit Organization
    /* Admin - Shift Module */
    Route::get('/shift', App\Livewire\Shift\Index::class)->name('shift.index'); // Shift Listing
    Route::get('/shift/create', App\Livewire\Shift\Create::class)->name('shift.create'); // Create Shift
    Route::get('/shift/{id}/edit', App\Livewire\Shift\Edit::class)->name('shift.edit'); // Edit Shift
    /* Admin - Sanction Module */
    Route::get('/sanction', App\Livewire\Sanction\Index::class)->name('sanction.index'); // Sanction Listing
    Route::get('/sanction/create', App\Livewire\Sanction\Create::class)->name('sanction.create'); // Create Sanction
    Route::get('/sanction/{id}/edit', App\Livewire\Sanction\Edit::class)->name('sanction.edit'); // Edit Sanction
    /* Admin - Demand Module */
    Route::get('/demand', App\Livewire\Demand\Index::class)->name('demand.index'); // Demand Listing
    Route::get('/demand/create', App\Livewire\Demand\Create::class)->name('demand.create'); // Create Demand
    Route::get('/demand/{id}/edit', App\Livewire\Demand\Edit::class)->name('demand.edit'); // Edit Demand
    /* Admin - PushNotificationTemplate Module */
    Route::get('/push-notification-template', App\Livewire\PushNotificationTemplate\Index::class)->name('push-notification-template.index'); // PushNotificationTemplate Listing
    Route::get('/push-notification-template/create', App\Livewire\PushNotificationTemplate\Create::class)->name('push-notification-template.create'); // Create PushNotificationTemplate
    Route::get('/push-notification-template/{id}/edit', App\Livewire\PushNotificationTemplate\Edit::class)->name('push-notification-template.edit'); // Edit PushNotificationTemplate
    /* Admin - SmsTemplate Module */
    Route::get('/sms-template', App\Livewire\SmsTemplate\Index::class)->name('sms-template.index'); // SmsTemplate Listing
    Route::get('/sms-template/create', App\Livewire\SmsTemplate\Create::class)->name('sms-template.create'); // Create SmsTemplate
    Route::get('/sms-template/{id}/edit', App\Livewire\SmsTemplate\Edit::class)->name('sms-template.edit'); // Edit SmsTemplate
});
