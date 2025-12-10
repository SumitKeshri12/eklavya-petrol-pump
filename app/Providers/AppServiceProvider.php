<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (App::environment(['local'])) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        $permissions = [
            'edit-emailformats', 'view-emailformats', 'edit-emailtemplates', 'show-emailtemplates', 'view-emailtemplates', 'view-role', 'show-role', 'add-role', 'edit-role', 'delete-role', 'bulkDelete-role', 'import-role', 'export-role', 'role-imports', 'view-user', 'show-user', 'add-user', 'edit-user', 'delete-user', 'bulkDelete-user', 'import-user', 'export-user', 'user-imports', 'view-fuel-config', 'show-fuel-config', 'add-fuel-config', 'edit-fuel-config', 'delete-fuel-config', 'bulkDelete-fuel-config', 'import-fuel-config', 'export-fuel-config', 'fuel-config-imports', 'view-product', 'show-product', 'add-product', 'edit-product', 'delete-product', 'bulkDelete-product', 'import-product', 'export-product', 'product-imports', 'view-dispenser', 'show-dispenser', 'add-dispenser', 'edit-dispenser', 'delete-dispenser', 'bulkDelete-dispenser', 'import-dispenser', 'export-dispenser', 'dispenser-imports', 'view-vehicle', 'show-vehicle', 'add-vehicle', 'edit-vehicle', 'delete-vehicle', 'bulkDelete-vehicle', 'import-vehicle', 'export-vehicle', 'vehicle-imports', 'view-organization', 'show-organization', 'add-organization', 'edit-organization', 'delete-organization', 'bulkDelete-organization', 'import-organization', 'export-organization', 'organization-imports', 'view-shift', 'show-shift', 'add-shift', 'edit-shift', 'delete-shift', 'bulkDelete-shift', 'import-shift', 'export-shift', 'shift-imports', 'view-sanction', 'show-sanction', 'add-sanction', 'edit-sanction', 'delete-sanction', 'bulkDelete-sanction', 'import-sanction', 'export-sanction', 'sanction-imports', 'view-demand', 'show-demand', 'add-demand', 'edit-demand', 'delete-demand', 'bulkDelete-demand', 'import-demand', 'export-demand', 'demand-imports', 'view-push-notification-template', 'show-push-notification-template', 'add-push-notification-template', 'edit-push-notification-template', 'delete-push-notification-template', 'bulkDelete-push-notification-template', 'import-push-notification-template', 'export-push-notification-template', 'push-notification-template-imports', 'view-sms-template', 'show-sms-template', 'add-sms-template', 'edit-sms-template', 'delete-sms-template', 'bulkDelete-sms-template', 'import-sms-template', 'export-sms-template', 'sms-template-imports',
        ];

        foreach ($permissions as $permission) {
            Gate::define($permission, function ($user) use ($permission) {
                return $user->hasPermission($permission, $user->role_id);
            });
        }
    }
}
