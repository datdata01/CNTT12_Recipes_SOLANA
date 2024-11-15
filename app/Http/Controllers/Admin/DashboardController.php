<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::whereHas('roles', function ($query) {
            $query->where('role_id', 1);
        })->count();

        $oneWeekAgo = Carbon::now()->subWeek()->toDateTimeString();

        $newUsers = User::whereHas('roles', function ($query) {
            $query->where('role_id', 1);
        })
            ->where('created_at', '>=', $oneWeekAgo)
            ->count();


        $totalCompleted = Order::where('status', 'COMPLETED')->sum('total_amount');


        // Đếm tổng số đơn hàng
        $totalOrders = Order::count();

        // Đếm số đơn hàng có status là "COMPLETED" giao thành công
        $completedOrders = Order::where('status', 'COMPLETED')->count();
        // Đếm số đơn hàng có status là "PENDING" đang chờ xử lý
        $pendingOrders = Order::where('status', 'PENDING')->count();
        // Đếm số đơn hàng có status là "DELIVERING" đang giao
        $deliveringOrders = Order::where('status', 'DELIVERING')->count();
        // Đếm số đơn hàng có status là "SHIPPED" đã giao
        $shippedOrders = Order::where('status', 'SHIPPED')->count();
        // Đếm số đơn hàng có status là "CANCELLED" giao thất bại 
        $cancelledOrders = Order::where('status', 'CANCELLED')->count();

        // Tính phần trăm đơn hàng hoàn thành thành công
        $successRate = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;

        // Tính tổng số lượng (quantity) của tất cả các biến thể sản phẩm
        $totalQuantity = ProductVariant::sum('quantity');

        // Tính tổng số lượng đã bán (sold) của tất cả các biến thể sản phẩm
        $totalSold = ProductVariant::sum('sold');

        $totalProduct = $totalQuantity - $totalSold;

        // Đếm tổng số bài viết
        $totalArticles = Article::count();


        $salesData = Product::with(['productVariants'])->get();
        // Lấy danh sách tên sản phẩm
        $labels = $salesData->pluck('name');
        // Lấy danh sách các số lượng bán (sold) của từng variants
        $data = $salesData->map(function ($product) {
            // Lấy tất cả các giá trị 'sold' của từng productVariants
            return $product->productVariants->sum('sold');
        });


        // tính số lượng tiền thu đc trong 1 tháng 
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total_revenue')
            ->where('status', 'COMPLETED')
            ->whereYear('created_at', Carbon::now()->year) // Lọc trong năm hiện tại
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        // Tạo mảng labels và data để truyền vào view
        $labelsMonthlyRevenue = [];
        $dataMonthlyRevenue = [];
        // Khởi tạo doanh thu từng tháng là 0
        for ($i = 1; $i <= 12; $i++) {
            $labelsMonthlyRevenue[] = "Tháng $i";
            $dataMonthlyRevenue[] = 0;
        }
        // Gán doanh thu vào từng tháng theo kết quả truy vấn
        foreach ($monthlyRevenue as $revenue) {
            $dataMonthlyRevenue[$revenue->month - 1] = $revenue->total_revenue;
        }


        // Tính doanh thu trong ngày hiện tại
        $todayRevenue = Order::selectRaw('SUM(total_amount) as total_revenue')
            ->where('status', 'COMPLETED')
            ->whereDate('created_at', Carbon::today()) // Lọc theo ngày hiện tại
            ->first();

        // Kiểm tra xem có doanh thu hay không, nếu không thì giá trị sẽ là 0
        $totalTodayRevenue = $todayRevenue ? $todayRevenue->total_revenue : 0;

        $feedbackCount = Feedback::whereNull('parent_feedback_id')->count();

        // Sản phẩm hết hàng
        $inactiveProducts = Product::where('status', 'IN_ACTIVE')->count();
        return view(
            'admin.pages.dashboard.index',
            compact(
                'totalUsers',
                'totalCompleted',
                'completedOrders',
                'pendingOrders',
                'deliveringOrders',
                'shippedOrders',
                'cancelledOrders',
                'newUsers',
                'successRate',
                'totalOrders',
                'totalProduct',
                'totalArticles',
                'feedbackCount',
                'labels',
                'data',
                'labelsMonthlyRevenue',
                'dataMonthlyRevenue',
                'totalTodayRevenue',
                'inactiveProducts'
            )
        );
    }
}
