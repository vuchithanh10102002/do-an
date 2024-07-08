<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;


class UserController extends Controller
{
    public static $levels = [
        [
            'code' => 'quanlyhethong',
            'name' => 'Quản lý hệ thống',
            'permissions' => [
                'login', 'check',
                'select',
                'get_user', 'delete_user', 'get_user_level', 'edit_user', 'add_user', 'get_current_user',
                'get_user_role', 'delete_user_role', 'edit_user_role', 'add_user_role',
                'get_branch', 'delete_branch', 'edit_branch', 'add_branch',
                'get_products', 'delete_products', 'edit_products', 'add_products',
                'get_customers', 'delete_customers', 'edit_customers', 'add_customers',
                'get_invoices', 'delete_invoices', 'edit_invoices', 'add_invoices',
                'get_supplier', 'delete_supplier', 'edit_supplier', 'add_supplier',
                'get_sale', 'delete_sale', 'edit_sale', 'add_sale',
                'setting_get', 'settings', 'setting_add',
                'get_products_by_package',
                'get_customer_cat', 'delete_customer_cat', 'edit_customer_cat', 'add_customer_cat',
                'get_product_return', 'delete_product_return', 'edit_product_return', 'add_product_return',
                'get_product_cat', 'delete_product_cat', 'edit_product_cat', 'add_product_cat',
                'get_product_list', 'delete_product_list', 'edit_product_list', 'add_product_list',
                'get_product_package', 'delete_product_package', 'edit_product_package', 'add_product_package',
                'get_product_move', 'delete_product_move', 'edit_product_move', 'add_product_move',
                'get_finance_cat', 'delete_finance_cat', 'edit_finance_cat', 'add_finance_cat',
                'get_product_return_import', 'delete_product_return_import', 'edit_product_return_import', 'add_product_return_import',
                'update_product_invoice',
                'add_product_import',
                'get_permissions'
            ]
        ],
        [
            'code' => 'quanlykho',
            'name' => 'Quản lý kho',
            'permissions' => []
        ], [
            'code' => 'ketoanbanhang',
            'name' => 'Kế toán bán hàng',
            'permissions' => []
        ], [
            'code' => 'thukho',
            'name' => 'Thủ kho',
            'permissions' => []
        ], [
            'code' => 'phukho',
            'name' => 'Phụ kho',
            'permissions' => []
        ], [
            'code' => 'ketoanhanhchinh',
            'name' => 'Kế toán hành chính',
            'permissions' => []
        ], [
            'code' => 'kiemsoat',
            'name' => 'Kiểm soát viên',
            'permissions' => []
        ], [
            'code' => 'kithuatvien',
            'name' => 'Kĩ thuật viên',
            'permissions' => []
        ],
        [
            'code' => 'nhanvienbanhang',
            'name' => 'Nhân viên bán hàng',
            'permissions' => [
                'login',
                'get_user', 'get_user_level',
                'get_branch',
                'get_products',
                'get_customers', 'add_customers',
                'get_invoices', 'add_invoices',
                'get_supplier',
                'setting_get',
            ]
        ],
    ];

    public static $permission = [
        ['title' => 'Cập nhật thông tin người dùng', 'des' => '', 'name' => 'edit_user', 'link' => '/api/users/*', 'method' => 'PUT'],
        ['title' => 'Xóa người dùng', 'des' => '', 'name' => 'delete_user', 'link' => '/api/users/*', 'method' => 'DELETE'],
        ['title' => 'Thêm người dùng', 'des' => '', 'name' => 'add_user', 'link' => '/api/users', 'method' => 'POST'],
        ['title' => 'Xem thông tin người dùng', 'des' => '', 'name' => 'show_user', 'link' => '/api/users/*', 'method' => 'GET'],
        ['title' => 'Xem thông tin cá nhân', 'des' => 'Bắt buộc', 'name' => 'get_current_user', 'link' => '/api/users-information', 'method' => 'GET'],
        ['title' => 'Xem danh sách người dùng', 'des' => '', 'name' => 'get_user', 'link' => '/api/users', 'method' => 'GET'],
        ['title' => 'Lấy cấp độ hiện tại', 'des' => '', 'name' => 'get_user_level', 'link' => '/api/users-levels', 'method' => 'GET'],

        ['title' => 'Sửa vai trò người dùng', 'des' => '', 'name' => 'edit_user_role', 'link' => '/api/user-roles/*', 'method' => 'PUT'],
        ['title' => 'Xóa vai trò người dùng', 'des' => '', 'name' => 'delete_user_role', 'link' => '/api/user-roles/*', 'method' => 'DELETE'],
        ['title' => 'Thêm vai trờ người dùng', 'des' => '', 'name' => 'add_user_role', 'link' => '/api/user-roles', 'method' => 'POST'],
        ['title' => 'Xem thông tin các vai trò người dùng', 'des' => 'Bắt buộc', 'name' => 'get_user_role', 'link' => '/api/user-roles', 'method' => 'GET'],

        ['title' => 'Sửa thông tin chi nhánh & kho', 'des' => '', 'name' => 'edit_branch', 'link' => '/api/branches/*', 'method' => 'PUT'],
        ['title' => 'Xóa chi nhánh & kho', 'des' => '', 'name' => 'delete_branch', 'link' => '/api/branches/*', 'method' => 'DELETE'],
        ['title' => 'Thêm mới chi nhánh & kho', 'des' => '', 'name' => 'add_branch', 'link' => '/api/branches', 'method' => 'POST'],
        ['title' => 'Xem danh sách chi nhánh & kho', 'des' => '', 'name' => 'show_branch', 'link' => '/api/branches/*', 'method' => 'GET'],
        ['title' => 'Lấy thông tin chi nhánh', 'des' => 'Bắt buộc', 'name' => 'get_branch', 'link' => '/api/branches', 'method' => 'GET'],

        ['title' => 'Sửa thông tin nhà cung cấp', 'des' => '', 'name' => 'edit_supplier', 'link' => '/api/suppliers/*', 'method' => 'PUT'],
        ['title' => 'Xóa nhà cung cấp', 'des' => '', 'name' => 'delete_supplier', 'link' => '/api/suppliers/*', 'method' => 'DELETE'],
        ['title' => 'Thêm nhà cung cấp mới', 'des' => '', 'name' => 'add_supplier', 'link' => '/api/suppliers', 'method' => 'POST'],
        ['title' => 'Xem danh sách nhà cung cấp', 'des' => '', 'name' => 'show_supplier', 'link' => '/api/suppliers', 'method' => 'GET'],
        ['title' => 'Lấy thông tin nhà cung cấp', 'des' => '', 'name' => 'get_supplier', 'link' => '/api/suppliers/*', 'method' => 'GET'],

        //        ['title' => 'Sửa thông tin sản phẩm', 'des' => '', 'name' => 'edit_products', 'link' => '/api/products/*', 'method' => 'PUT'],
        //        ['title' => 'Xóa sản phẩm', 'des' => '', 'name' => 'delete_products', 'link' => '/api/products/*', 'method' => 'DELETE'],
        //        ['title' => 'Thêm sản phẩm mới', 'des' => '', 'name' => 'add_products', 'link' => '/api/products', 'method' => 'POST'],
        //        ['title' => 'Xem danh sách sản phẩm', 'des' => '', 'name' => 'show_products', 'link' => '/products', 'method' => 'GET'],
        //        ['title' => 'Lấy thông tin sản phẩm', 'des' => '', 'name' => 'get_products', 'link' => '/api/products', 'method' => 'GET'],

        ['title' => 'Sửa thông tin khách hàng', 'des' => '', 'name' => 'edit_customers', 'link' => '/api/customers/*', 'method' => 'PUT'],
        ['title' => 'Xóa khách hàng', 'des' => '', 'name' => 'delete_customers', 'link' => '/api/customers/*', 'method' => 'DELETE'],
        ['title' => 'Thêm khách hàng mới', 'des' => '', 'name' => 'add_customers', 'link' => '/api/customers', 'method' => 'POST'],
        ['title' => 'Xem danh sách khách hàng', 'des' => '', 'name' => 'show_customers', 'link' => '/api/customers', 'method' => 'GET'],
        ['title' => 'Lấy thông tin khách hàng', 'des' => 'Nên cấp quyền', 'name' => 'get_customers', 'link' => '/api/customers/*', 'method' => 'GET'],

        ['title' => 'Sửa thông tin hóa đơn', 'des' => '', 'name' => 'edit_invoices', 'link' => '/api/invoices/*', 'method' => 'PUT'],
        ['title' => 'Xóa hóa đơn', 'des' => '', 'name' => 'delete_invoices', 'link' => '/api/invoices/*', 'method' => 'DELETE'],
        ['title' => 'Thêm hóa đơn mới', 'des' => '', 'name' => 'add_invoices', 'link' => '/api/invoices', 'method' => 'POST'],
        ['title' => 'Xem danh sách hóa đơn', 'des' => '', 'name' => 'show_invoices', 'link' => '/invoices', 'method' => 'GET'],
        ['title' => 'Lấy thông tin hóa đơn', 'des' => '', 'name' => 'get_invoices', 'link' => '/api/invoices', 'method' => 'GET'],

        ['title' => 'Sửa danh mục khách hàng', 'des' => '', 'name' => 'edit_customer_cat', 'link' => '/api/customer-cat/*', 'method' => 'PUT'],
        ['title' => 'Xóa danh mục khách hàng', 'des' => '', 'name' => 'delete_customer_cat', 'link' => '/api/customer-cat/*', 'method' => 'DELETE'],
        ['title' => 'Thêm danh mục khách hàng', 'des' => '', 'name' => 'add_customer_cat', 'link' => '/api/customer-cat', 'method' => 'POST'],
        ['title' => 'Xem danh sách danh mục khách hàng', 'des' => '', 'name' => 'show_customer_cat', 'link' => '/customer-cat', 'method' => 'GET'],
        ['title' => 'Lấy thông tin danh mục khách hàng', 'des' => '', 'name' => 'get_customer_cat', 'link' => '/api/customer-cat', 'method' => 'GET'],

        ['title' => 'Sửa danh mục sản phẩm', 'des' => '', 'name' => 'edit_product_cat', 'link' => '/api/product-cat/*', 'method' => 'PUT'],
        ['title' => 'Xóa danh mục sản phẩm', 'des' => '', 'name' => 'delete_product_cat', 'link' => '/api/product-cat/*', 'method' => 'DELETE'],
        ['title' => 'Thêm danh mục sản phẩm', 'des' => '', 'name' => 'add_product_cat', 'link' => '/api/product-cat', 'method' => 'POST'],
        ['title' => 'Xem danh sách danh mục sản phẩm', 'des' => '', 'name' => 'show_product_cat', 'link' => '/api/product-cat', 'method' => 'GET'],
        ['title' => 'Lấy thông tin danh mục sản phẩm', 'des' => 'Bắt buộc', 'name' => 'get_product_cat', 'link' => '/api/product-cat/*', 'method' => 'GET'],

        ['title' => 'Sửa danh sách sản phẩm', 'des' => '', 'name' => 'edit_product_list', 'link' => '/api/product-list/*', 'method' => 'PUT'],
        ['title' => 'Xóa danh sách sản phẩm', 'des' => '', 'name' => 'delete_product_list', 'link' => '/api/product-list/*', 'method' => 'DELETE'],
        ['title' => 'Thêm danh sách sản phẩm', 'des' => '', 'name' => 'add_product_list', 'link' => '/api/product-list', 'method' => 'POST'],
        ['title' => 'Xem danh sách sản phẩm', 'des' => 'Bắt buộc', 'name' => 'show_product_list', 'link' => '/api/product-list', 'method' => 'GET'],
        ['title' => 'Lấy thông tin sản phẩm', 'des' => 'Bắt buộc', 'name' => 'get_product_list', 'link' => '/api/product-list/*', 'method' => 'GET'],

        ['title' => 'Cập nhật dữ liệu web sản phẩm', 'des' => '', 'name' => 'add_product_data', 'link' => '/api/product-data', 'method' => 'POST'],

        ['title' => 'Sửa danh sách thu chi', 'des' => '', 'name' => 'edit_finance', 'link' => '/api/finance/*', 'method' => 'PUT'],
        ['title' => 'Xóa phiếu thi chi', 'des' => '', 'name' => 'delete_finance', 'link' => '/api/finance/*', 'method' => 'DELETE'],
        ['title' => 'Thêm phiếu thu chi', 'des' => '', 'name' => 'add_finance', 'link' => '/api/finance', 'method' => 'POST'],
        ['title' => 'Xem danh sách phiếu thu chi', 'des' => 'Bắt buộc', 'name' => 'show_finance', 'link' => '/finance', 'method' => 'GET'],
        ['title' => 'Lấy thông tin thu chi', 'des' => 'Bắt buộc', 'name' => 'get_finance', 'link' => '/api/finance', 'method' => 'GET'],
        //
        //        ['title' => '', 'des' => '', 'name' => 'edit_product_package', 'link' => '/api/product-package/*', 'method' => 'PUT'],
        //        ['title' => '', 'des' => '', 'name' => 'delete_product_package', 'link' => '/api/product-package/*', 'method' => 'DELETE'],
        //        ['title' => '', 'des' => '', 'name' => 'add_product_package', 'link' => '/api/product-package', 'method' => 'POST'],
        //        ['title' => '', 'des' => '', 'name' => 'show_product_package', 'link' => '/product-package', 'method' => 'GET'],
        //        ['title' => '', 'des' => '', 'name' => 'get_product_package', 'link' => '/api/product-package', 'method' => 'GET'],

        ['title' => 'Sửa thông tin chuyển hàng', 'des' => '', 'name' => 'edit_product_move', 'link' => '/api/product-move/*', 'method' => 'PUT'],
        ['title' => 'Xóa chuyển hàng', 'des' => '', 'name' => 'delete_product_move', 'link' => '/api/product-move/*', 'method' => 'DELETE'],
        ['title' => 'Chuyển hàng hóa', 'des' => '', 'name' => 'add_product_move', 'link' => '/api/product-move', 'method' => 'POST'],
        ['title' => 'Xem danh sách chuyển hàng', 'des' => '', 'name' => 'show_product_move', 'link' => '/api/product-move', 'method' => 'GET'],
        ['title' => 'Lấy thông tin chuyển hàng', 'des' => '', 'name' => 'get_product_move', 'link' => '/api/product-move/*', 'method' => 'GET'],

        ['title' => 'Sửa phiếu thêm hàng vào kho', 'des' => '', 'name' => 'edit_product_self_produced', 'link' => '/api/product-import-self-produced/*', 'method' => 'PUT'],
        ['title' => 'Xóa phiếu thêm hàng vào kho', 'des' => '', 'name' => 'delete_product_self_produced', 'link' => '/api/product-import-self-produced/*', 'method' => 'DELETE'],
        ['title' => 'Thêm hàng vào kho', 'des' => '', 'name' => 'add_product_self_produced', 'link' => '/api/product-import-self-produced', 'method' => 'POST'],
        ['title' => 'Xem danh sách phiếu thêm hàng vào kho', 'des' => '', 'name' => 'show_product_self_produced', 'link' => '/api/product-import-self-produced', 'method' => 'GET'],
        ['title' => 'Lấy thông tin phiếu thêm hàng vào kho', 'des' => '', 'name' => 'get_product_self_produced', 'link' => '/api/product-import-self-produced/*', 'method' => 'GET'],

        ['title' => 'Sửa thông tin bán hàng', 'des' => '', 'name' => 'edit_sale', 'link' => '/api/sale/*', 'method' => 'PUT'],
        ['title' => 'Xóa hóa đơn bán hàng', 'des' => '', 'name' => 'delete_sale', 'link' => '/api/sale/*', 'method' => 'DELETE'],
        ['title' => 'Bán hàng', 'des' => '', 'name' => 'add_sale', 'link' => '/api/sale', 'method' => 'POST'],
        ['title' => 'Xem hóa đơn bán hàng', 'des' => '', 'name' => 'show_sale', 'link' => '/api/sale', 'method' => 'GET'],
        ['title' => 'Lấy thông tin hóa đơn bán hàng', 'des' => '', 'name' => 'get_sale', 'link' => '/api/sale/*', 'method' => 'GET'],

        ['title' => 'Sửa phiếu trả hàng nhập', 'des' => '', 'name' => 'edit_product_return_import', 'link' => '/api/product-return-import/*', 'method' => 'PUT'],
        ['title' => 'Xóa phiếu trả hàng nhập', 'des' => '', 'name' => 'delete_product_return_import', 'link' => '/api/product-return-import/*', 'method' => 'DELETE'],
        ['title' => 'Thêm phiếu trả hàng nhập', 'des' => '', 'name' => 'add_product_return_import', 'link' => '/api/product-return-import', 'method' => 'POST'],
        ['title' => 'Xem danh sách phiếu trả hàng nhập', 'des' => '', 'name' => 'show_product_return_import', 'link' => '/api/product-return-import', 'method' => 'GET'],
        ['title' => 'Lấy thông tin phiếu trả hàng nhập', 'des' => '', 'name' => 'get_product_return_import', 'link' => '/api/product-return-import/*', 'method' => 'GET'],

        ['title' => 'Sửa danh mục tài khoản', 'des' => '', 'name' => 'edit_finance_cat', 'link' => '/api/finance-cat/*', 'method' => 'PUT'],
        ['title' => 'Xóa danh mục tài khoản', 'des' => '', 'name' => 'delete_finance_cat', 'link' => '/api/finance-cat/*', 'method' => 'DELETE'],
        ['title' => 'Thêm danh mục tài khoản', 'des' => '', 'name' => 'add_finance_cat', 'link' => '/api/finance-cat', 'method' => 'POST'],
        ['title' => 'Xem danh sách danh mục tài khoản', 'des' => '', 'name' => 'show_finance_cat', 'link' => '/finance-cat', 'method' => 'GET'],
        ['title' => 'Lấy thông tin danh mục tài khoản', 'des' => '', 'name' => 'get_finance_cat', 'link' => '/api/finance-cat', 'method' => 'GET'],

        ['title' => 'Sửa phiếu trả hàng', 'des' => '', 'name' => 'edit_product_return', 'link' => '/api/product-return/*', 'method' => 'PUT'],
        ['title' => 'Xóa phiếu trả hàng', 'des' => '', 'name' => 'delete_product_return', 'link' => '/api/product-return/*', 'method' => 'DELETE'],
        ['title' => 'Thêm phiếu trả hàng', 'des' => '', 'name' => 'add_product_return', 'link' => '/api/product-return', 'method' => 'POST'],
        ['title' => 'Xem danh sách phiếu trả hàng', 'des' => '', 'name' => 'show_product_return', 'link' => '/api/product-return', 'method' => 'GET'],
        ['title' => 'Lấy thông tin phiếu trả hàng', 'des' => '', 'name' => 'get_product_return', 'link' => '/api/product-return/*', 'method' => 'GET'],

        ['title' => 'Thêm sản phẩm nhập hàng', 'des' => '', 'name' => 'add_product_import', 'link' => '/api/product-import', 'method' => 'POST'],
        ['title' => 'Xóa phiếu nhập hàng', 'des' => '', 'name' => 'delete_product_import', 'link' => '/api/product-import/*', 'method' => 'DELETE'],

        ['title' => 'Lấy thông tin cài đặt', 'des' => '', 'name' => 'setting_get', 'link' => '/api/setting/', 'method' => 'GET'],
        ['title' => 'Cài đặt hệ thống', 'des' => '', 'name' => 'setting_add', 'link' => '/api/settings', 'method' => 'POST'],
        ['title' => 'Cập nhật cài đặt', 'des' => '', 'name' => 'settings', 'link' => '/api/settings/*', 'method' => 'PUT'],
        ['title' => 'Lấy danh sách sản phẩm theo gói', 'des' => '', 'name' => 'get_products_by_package', 'link' => '/api/get-products-by-package', 'method' => 'GET'],

        ['title' => 'Đăng nhập hệ thống', 'des' => 'Bắt buộc', 'name' => 'login', 'link' => '/api/login', 'method' => 'POST'],
        ['title' => 'Kiểm tra trạng thái đăng nhập', 'des' => 'Bắt buộc', 'name' => 'check', 'link' => '/api/check', 'method' => 'GET'],
        ['title' => 'Truy xuất dữ liệu báo cáo', 'des' => '', 'name' => 'select', 'link' => '/api/select', 'method' => 'GET'],
        ['title' => 'Cập nhật sản phẩm hóa đơn', 'des' => '', 'name' => 'update_product_invoice', 'link' => '/api/update-product-invoice', 'method' => 'PUT'],

        ['title' => 'Lấy danh sách vai trò', 'des' => '', 'name' => 'get_permissions', 'link' => '/api/permissions', 'method' => 'GET'],
    ];


    public function getView()
    {
        return view('page.user.users');
    }
}
