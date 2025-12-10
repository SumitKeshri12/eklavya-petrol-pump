<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::truncate();
        Cache::forget('getAllPermissions');

        Permission::insert([
            ['name' => 'emailformats', 'guard_name' => 'root', 'label' => 'Email Formats', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-emailformats', 'guard_name' => 'emailformats', 'label' => 'View', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-emailformats', 'guard_name' => 'emailformats', 'label' => 'Edit', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'emailtemplates', 'guard_name' => 'root', 'label' => 'Email Templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-emailtemplates', 'guard_name' => 'emailtemplates', 'label' => 'View', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-emailtemplates', 'guard_name' => 'emailtemplates', 'label' => 'Show', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-emailtemplates', 'guard_name' => 'emailtemplates', 'label' => 'Edit', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'roles', 'label' => 'Role', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-role', 'label' => 'View', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-role', 'label' => 'Show', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-role', 'label' => 'Add', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-role', 'label' => 'Edit', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-role', 'label' => 'Delete', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-role', 'label' => 'Bulk Delete', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-role', 'label' => 'Import', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-role', 'label' => 'Export', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'users', 'label' => 'User', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-user', 'label' => 'View', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-user', 'label' => 'Show', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-user', 'label' => 'Add', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-user', 'label' => 'Edit', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-user', 'label' => 'Delete', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-user', 'label' => 'Bulk Delete', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-user', 'label' => 'Import', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-user', 'label' => 'Export', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'fuel_configs', 'label' => 'Fuel Config', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-fuel-config', 'label' => 'View', 'guard_name' => 'fuel_configs', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-fuel-config', 'label' => 'Show', 'guard_name' => 'fuel_configs', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-fuel-config', 'label' => 'Add', 'guard_name' => 'fuel_configs', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-fuel-config', 'label' => 'Edit', 'guard_name' => 'fuel_configs', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-fuel-config', 'label' => 'Delete', 'guard_name' => 'fuel_configs', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-fuel-config', 'label' => 'Bulk Delete', 'guard_name' => 'fuel_configs', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-fuel-config', 'label' => 'Import', 'guard_name' => 'fuel_configs', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-fuel-config', 'label' => 'Export', 'guard_name' => 'fuel_configs', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'products', 'label' => 'Product', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-product', 'label' => 'View', 'guard_name' => 'products', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-product', 'label' => 'Show', 'guard_name' => 'products', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-product', 'label' => 'Add', 'guard_name' => 'products', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-product', 'label' => 'Edit', 'guard_name' => 'products', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-product', 'label' => 'Delete', 'guard_name' => 'products', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-product', 'label' => 'Bulk Delete', 'guard_name' => 'products', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-product', 'label' => 'Import', 'guard_name' => 'products', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-product', 'label' => 'Export', 'guard_name' => 'products', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'dispensers', 'label' => 'Dispenser', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-dispenser', 'label' => 'View', 'guard_name' => 'dispensers', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-dispenser', 'label' => 'Show', 'guard_name' => 'dispensers', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-dispenser', 'label' => 'Add', 'guard_name' => 'dispensers', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-dispenser', 'label' => 'Edit', 'guard_name' => 'dispensers', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-dispenser', 'label' => 'Delete', 'guard_name' => 'dispensers', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-dispenser', 'label' => 'Bulk Delete', 'guard_name' => 'dispensers', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-dispenser', 'label' => 'Import', 'guard_name' => 'dispensers', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-dispenser', 'label' => 'Export', 'guard_name' => 'dispensers', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'vehicles', 'label' => 'Vehicle', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-vehicle', 'label' => 'View', 'guard_name' => 'vehicles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-vehicle', 'label' => 'Show', 'guard_name' => 'vehicles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-vehicle', 'label' => 'Add', 'guard_name' => 'vehicles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-vehicle', 'label' => 'Edit', 'guard_name' => 'vehicles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-vehicle', 'label' => 'Delete', 'guard_name' => 'vehicles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-vehicle', 'label' => 'Bulk Delete', 'guard_name' => 'vehicles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-vehicle', 'label' => 'Import', 'guard_name' => 'vehicles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-vehicle', 'label' => 'Export', 'guard_name' => 'vehicles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'organizations', 'label' => 'Organization', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-organization', 'label' => 'View', 'guard_name' => 'organizations', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-organization', 'label' => 'Show', 'guard_name' => 'organizations', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-organization', 'label' => 'Add', 'guard_name' => 'organizations', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-organization', 'label' => 'Edit', 'guard_name' => 'organizations', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-organization', 'label' => 'Delete', 'guard_name' => 'organizations', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-organization', 'label' => 'Bulk Delete', 'guard_name' => 'organizations', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-organization', 'label' => 'Import', 'guard_name' => 'organizations', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-organization', 'label' => 'Export', 'guard_name' => 'organizations', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'shifts', 'label' => 'Shift', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-shift', 'label' => 'View', 'guard_name' => 'shifts', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-shift', 'label' => 'Show', 'guard_name' => 'shifts', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-shift', 'label' => 'Add', 'guard_name' => 'shifts', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-shift', 'label' => 'Edit', 'guard_name' => 'shifts', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-shift', 'label' => 'Delete', 'guard_name' => 'shifts', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-shift', 'label' => 'Bulk Delete', 'guard_name' => 'shifts', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-shift', 'label' => 'Import', 'guard_name' => 'shifts', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-shift', 'label' => 'Export', 'guard_name' => 'shifts', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'sanctions', 'label' => 'Sanction', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-sanction', 'label' => 'View', 'guard_name' => 'sanctions', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-sanction', 'label' => 'Show', 'guard_name' => 'sanctions', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-sanction', 'label' => 'Add', 'guard_name' => 'sanctions', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-sanction', 'label' => 'Edit', 'guard_name' => 'sanctions', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-sanction', 'label' => 'Delete', 'guard_name' => 'sanctions', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-sanction', 'label' => 'Bulk Delete', 'guard_name' => 'sanctions', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-sanction', 'label' => 'Import', 'guard_name' => 'sanctions', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-sanction', 'label' => 'Export', 'guard_name' => 'sanctions', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'demands', 'label' => 'Demand', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-demand', 'label' => 'View', 'guard_name' => 'demands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-demand', 'label' => 'Show', 'guard_name' => 'demands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-demand', 'label' => 'Add', 'guard_name' => 'demands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-demand', 'label' => 'Edit', 'guard_name' => 'demands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-demand', 'label' => 'Delete', 'guard_name' => 'demands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-demand', 'label' => 'Bulk Delete', 'guard_name' => 'demands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-demand', 'label' => 'Import', 'guard_name' => 'demands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-demand', 'label' => 'Export', 'guard_name' => 'demands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'push_notification_templates', 'label' => 'Push Notification Template', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-push-notification-template', 'label' => 'View', 'guard_name' => 'push_notification_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-push-notification-template', 'label' => 'Show', 'guard_name' => 'push_notification_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-push-notification-template', 'label' => 'Add', 'guard_name' => 'push_notification_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-push-notification-template', 'label' => 'Edit', 'guard_name' => 'push_notification_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-push-notification-template', 'label' => 'Delete', 'guard_name' => 'push_notification_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-push-notification-template', 'label' => 'Bulk Delete', 'guard_name' => 'push_notification_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-push-notification-template', 'label' => 'Import', 'guard_name' => 'push_notification_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-push-notification-template', 'label' => 'Export', 'guard_name' => 'push_notification_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

            ['name' => 'sms_templates', 'label' => 'Sms Template', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-sms-template', 'label' => 'View', 'guard_name' => 'sms_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-sms-template', 'label' => 'Show', 'guard_name' => 'sms_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-sms-template', 'label' => 'Add', 'guard_name' => 'sms_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-sms-template', 'label' => 'Edit', 'guard_name' => 'sms_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-sms-template', 'label' => 'Delete', 'guard_name' => 'sms_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-sms-template', 'label' => 'Bulk Delete', 'guard_name' => 'sms_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-sms-template', 'label' => 'Import', 'guard_name' => 'sms_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-sms-template', 'label' => 'Export', 'guard_name' => 'sms_templates', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
        ]);
    }
}
