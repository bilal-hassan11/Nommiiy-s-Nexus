<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            // User
            ['name' => 'can_add_user', 'module_name' => 'User'],
            ['name' => 'can_edit_user', 'module_name' => 'User'],
            ['name' => 'can_view_user', 'module_name' => 'User'],
            ['name' => 'can_delete_user', 'module_name' => 'User'],
            ['name' => 'can_change_user_status', 'module_name' => 'User'],
            
            // Role
            ['name' => 'can_add_role', 'module_name' => 'Role'],
            ['name' => 'can_edit_role', 'module_name' => 'Role'],
            ['name' => 'can_view_role', 'module_name' => 'Role'],
            ['name' => 'can_delete_role', 'module_name' => 'Role'],

            // Customer
            ['name' => 'can_add_customer', 'module_name' => 'Customer'],
            ['name' => 'can_edit_customer', 'module_name' => 'Customer'],
            ['name' => 'can_view_customer', 'module_name' => 'Customer'],
            ['name' => 'can_delete_customer', 'module_name' => 'Customer'],
            ['name' => 'can_change_customer_status', 'module_name' => 'Customer'],

            // Supplier
            ['name' => 'can_add_supplier', 'module_name' => 'Supplier'],
            ['name' => 'can_edit_supplier', 'module_name' => 'Supplier'],
            ['name' => 'can_view_supplier', 'module_name' => 'Supplier'],
            ['name' => 'can_delete_supplier', 'module_name' => 'Supplier'],
            ['name' => 'can_change_supplier_status', 'module_name' => 'Supplier'],

            // Product
            ['name' => 'can_add_product', 'module_name' => 'Product'],
            ['name' => 'can_edit_product', 'module_name' => 'Product'],
            ['name' => 'can_view_product', 'module_name' => 'Product'],
            ['name' => 'can_delete_product', 'module_name' => 'Product'],

            // Category
            ['name' => 'can_add_product_category', 'module_name' => 'Category'],
            ['name' => 'can_edit_product_category', 'module_name' => 'Category'],
            ['name' => 'can_view_product_category', 'module_name' => 'Category'],
            ['name' => 'can_delete_product_category', 'module_name' => 'Category'],
 
            // Tax
            ['name' => 'can_add_tax', 'module_name' => 'Tax'],
            ['name' => 'can_edit_tax', 'module_name' => 'Tax'],
            ['name' => 'can_view_tax', 'module_name' => 'Tax'],
            ['name' => 'can_delete_tax', 'module_name' => 'Tax'],

            // Discounts
            ['name' => 'can_add_discount', 'module_name' => 'Discount'],
            ['name' => 'can_edit_discount', 'module_name' => 'Discount'],
            ['name' => 'can_view_discount', 'module_name' => 'Discount'],
            ['name' => 'can_delete_discount', 'module_name' => 'Discount'],

            // Purchase Orders
            ['name' => 'can_add_purchase_order', 'module_name' => 'Purchase Order'],
            ['name' => 'can_edit_purchase_order', 'module_name' => 'Purchase Order'],
            ['name' => 'can_view_purchase_order', 'module_name' => 'Purchase Order'],
            ['name' => 'can_delete_purchase_order', 'module_name' => 'Purchase Order'],

            // Add Stock
            ['name' => 'can_add_stock', 'module_name' => 'Stock'],
            ['name' => 'can_view_stock', 'module_name' => 'Stock'],

            // B2B
            ['name' => 'can_invite_business', 'module_name' => 'B2B'],
            ['name' => 'can_remove_business', 'module_name' => 'B2B'],
            ['name' => 'can_transfer_business', 'module_name' => 'B2B'],
            ['name' => 'can_reject_business_request', 'module_name' => 'B2B'],
            ['name' => 'can_view_business', 'module_name' => 'B2B'],
            ['name' => 'can_requested_business', 'module_name' => 'B2B'],
            ['name' => 'can_approve_business_request', 'module_name' => 'B2B'],
            ['name' => 'can_see_business_history', 'module_name' => 'B2B'],

            // Sales Orders
            ['name' => 'can_add_sales_order', 'module_name' => 'Sales Order'],
            ['name' => 'can_edit_sales_order', 'module_name' => 'Sales Order'],
            ['name' => 'can_view_sales_order', 'module_name' => 'Sales Order'],
            ['name' => 'can_delete_sales_order', 'module_name' => 'Sales Order'],
            ['name' => 'can_change_sales_status_order', 'module_name' => 'Sales Order'],

            // Payments
            ['name' => 'can_see_payment', 'module_name' => 'Payments'],
            ['name' => 'can_view_payment_history', 'module_name' => 'Payments'],
            ['name' => 'can_add_payment', 'module_name' => 'Payments'],

            // Reports
            ['name' => 'can_see_report_sales', 'module_name' => 'Reports'],
            ['name' => 'can_view_report_purchase', 'module_name' => 'Reports'],
            ['name' => 'can_view_report_available_inventory', 'module_name' => 'Reports'],
            ['name' => 'can_view_report_cash_flow', 'module_name' => 'Reports'],

            // Available Inventory
            ['name' => 'can_see_available_inventory', 'module_name' => 'Available Inventory'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}
