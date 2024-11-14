<?php

namespace App\Http\Controllers;

use App\Events\ForgotPasswordEvent;
use App\Events\VerifyEmailEvent;
use App\Http\Requests\Auth\FogetPassRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ChangePassRequest;
use App\Mail\FogotPass;
use App\Mail\VerifyAccount;
use App\Models\Role;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Auth;
use Cookie;
use Flasher\Prime\Notification\NotificationInterface;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginView()
    {
        // Trả về trang đăng nhập từ view 'client.pages.auth.login'
        return view('client.pages.auth.login');
    }
    public function storeLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        // Kiểm tra xem tài khoản có tồn tại không
        if (!$user) {
            toastr("Tài khoản không tồn tại", NotificationInterface::ERROR, "Đăng nhập thất bại");
            return back();
        }
        if ($user->status !== 'ACTIVE') {
            // Lưu thông báo vào session
            toastr("Tài khoản đã bị khóa.", NotificationInterface::ERROR, "Cảnh báo", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return redirect()->route('auth.login-view');
        }
        if ($user->email_verified_at == null) {
            Mail::to($user->email)->send(new VerifyAccount($user));
            // Thông báo đăng ký thành công và yêu cầu xác thực email
            toastr("Vui lòng kiểm tra email để xác thực tài khoản", NotificationInterface::SUCCESS, "Xác thực email", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            // Chuyển hướng người dùng đến trang đăng nhập
            return back();
        }
        // Kiểm tra thời gian gần đây nhất cố gắng đăng nhập
        if ($user->last_login_attempt) {
            $lastLoginAttempt = Carbon::parse($user->last_login_attempt);
            // Kiểm tra thời gian hết hạn
            if ($lastLoginAttempt->addMinutes(15) > now() && $user->login_attempts >= 10) {
                toastr("Tài khoản đã bị khóa do nhập sai quá nhiều lần. Vui lòng liên hệ shop để mở.", NotificationInterface::ERROR);
                return back();
            }
        }
        // Thực hiện đăng nhập
        if (Auth::attempt($credentials)) {
            if ($request->has('remember')) {
                // Lưu email vào cookie với thời gian sống là 60 phút
                cookie()->queue(cookie('email', $request->email, 60));
                // Lưu mật khẩu vào cookie với thời gian sống là 60 phút (nên xem xét lại vì lý do bảo mật)
                cookie()->queue(cookie('password', $request->password, 60));
            }
            // Nếu đăng nhập thành công
            $user->login_attempts = 0; // Reset số lần cố gắng đăng nhập
            $user->last_login_attempt = null; // Reset thời gian cố gắng đăng nhập
            $user->save();



            // dang nhap tai khoan admin thi ban sang admin
            // if (Auth::id() == 2) {
            //     toastr("Đăng nhập thành công", NotificationInterface::SUCCESS, "Thành công");
            //     return redirect()->route('test');
            // }


            toastr("Đăng nhập thành công", NotificationInterface::SUCCESS, "Thành công");
            return redirect()->route('home');
        } else {
            // Nếu đăng nhập không thành công
            $user->login_attempts++;
            $user->last_login_attempt = now(); // Cập nhật thời gian cố gắng đăng nhập
            $user->save();

            if ($user->login_attempts >= 10) {
                $user->status = 'IN_ACTIVE'; // Khóa tài khoản
                $user->save();

                toastr("Tài khoản đã bị khóa do nhập sai quá nhiều lần.", NotificationInterface::ERROR, "Lỗi");
                return back();
            }

            toastr("Thông tin tài khoản hoặc mật khẩu không chính xác", NotificationInterface::ERROR, "Lỗi");
            return back();
        }
    }
    public function registerView()
    {
        // Trả về trang đăng ký từ view 'client.pages.auth.register'
        return view('client.pages.auth.register');
    }
    public function storeRegister(RegisterRequest $request)
    {
        // Lấy và validate dữ liệu từ form đăng ký
        $validatedData = $request->validated();

        // Thực hiện các thao tác trong một giao dịch
        DB::transaction(function () use ($validatedData) {
            // Kiểm tra và thêm vai trò mặc định nếu chưa tồn tại
            $role = Role::firstOrCreate(
                ['id' => 1],
                ['name' => 'User', 'description' => 'Vai trò mặc định cho người dùng']
            );
            Role::firstOrCreate(
                ['id' => 2],
                ['name' => 'Adim', 'description' => 'Vai trò Quản lý']
            );
            // Tạo người dùng mới từ dữ liệu đã validate
            $user = User::create([
                'full_name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']), // Mã hóa mật khẩu
                'status' => 'ACTIVE', // Đặt trạng thái mặc định là 'ACTIVE'
                'image' => $validatedData['image'] ?? null, // Lưu ảnh (nếu có)
                'phone' => $validatedData['phone'], // Lưu số điện thoại
            ]);

            // Gán vai trò mặc định cho người dùng
            $user->roles()->sync([$role->id]);

            // Gửi email xác thực tài khoản
//            Mail::to($user->email)->send(new VerifyAccount($user));
            // gui bang event
            VerifyEmailEvent::dispatch($user);

            $voucher = Voucher::where('type', 'SUCCESS')->first();

            if ($voucher) {
                $startDate = Carbon::now()->lt($voucher->start_date) ? $voucher->start_date : Carbon::now();

                $data = [
                    "user_id"       => $user->id,
                    "voucher_id"    => $voucher->id,
                    "vourcher_code" => strtoupper(Str::random(8)),
                    "start_date"    => $startDate,
                    "end_date"      => $voucher->end_date,
                    "status"        => "ACTIVE",
                ];

                VoucherUsage::create($data);
            }
        });

        // Thông báo đăng ký thành công và yêu cầu xác thực email
        toastr("Vui lòng kiểm tra email để xác thực tài khoản", NotificationInterface::SUCCESS, "Đăng ký tài khoản thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        // Chuyển hướng người dùng đến trang đăng nhập
        return redirect()->route('auth.login-view');
    }
    public function verify($email)
    {
        // Tìm tài khoản với email tương ứng
        $acc = User::where('email', $email)->first();
        // Kiểm tra xem tài khoản đã được xác thực chưa
        if ($acc && !$acc->email_verified_at) {
            // Nếu chưa, cập nhật email_verified_at để xác thực tài khoản
            User::where('email', $email)->update(['email_verified_at' => now()]);

            // Thông báo xác thực thành công
            toastr("Tài khoản của bạn đã được xác thực thành công! <br> Vui lòng đăng nhập tài khoản", NotificationInterface::SUCCESS, "Xác thực tài khoản thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } elseif ($acc && $acc->email_verified_at) {
            // Nếu tài khoản đã được xác thực trước đó, thông báo lỗi
            toastr("Tài khoản của bạn đã được xác thực trước đó.", NotificationInterface::ERROR, "Xác thực tài khoản", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } else {
            // Nếu không tìm thấy tài khoản, thông báo lỗi
            toastr("Tài khoản không tồn tại.", NotificationInterface::ERROR, "Xác thực tài khoản", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        }
        // Chuyển hướng người dùng về trang đăng nhập
        return redirect()->route('auth.login-view');
    }
    public function fogetPasswordView()
    {
        // Trả về trang quên mật khẩu từ view 'client.pages.auth.foget-password'
        return view('client.pages.auth.foget-password');
    }
    public function checkfogetPasswordView(FogetPassRequest $request)
    {
        // Tìm người dùng dựa vào email đã nhập
        $user = User::where('email', $request->email)->first();

        // Kiểm tra nếu người dùng tồn tại
        if ($user) {
            // Kiểm tra thời gian yêu cầu đặt lại mật khẩu lần trước (15 phút)
            $timeLimit = now()->subMinutes(15);
            if ($user->password_changed_at && $user->password_changed_at > $timeLimit) {
                toastr('Bạn đã yêu cầu lấy lại mật khẩu gần đây, vui lòng thử lại sau 15 phút.', NotificationInterface::WARNING, 'Yêu cầu quá nhiều', [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);
                return back();
            }
            // Nếu vượt quá thời gian giới hạn, tiến hành cập nhật mật khẩu
            $newPassword = $this->generateSecurePassword();
            // Cập nhật mật khẩu mới cho người dùng (mã hóa mật khẩu)
            $user->password = Hash::make($newPassword);
            $user->password_changed_at = now(); // Cập nhật thời gian thực
            $user->save(); // Lưu tất cả thay đổi
            // Gửi email chứa mật khẩu mới
//            Mail::to($user->email)->send(new FogotPass($user, $newPassword));
            // gui bang event
            ForgotPasswordEvent::dispatch($user,$newPassword);
            // Thông báo thành công
            toastr('Vui lòng kiểm tra email để nhận mật khẩu mới', NotificationInterface::SUCCESS, 'Lấy lại mật khẩu thành công', [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } else {
            // Nếu không tìm thấy tài khoản, thông báo lỗi
            toastr('Email không tồn tại trong hệ thống', NotificationInterface::ERROR, 'Lấy lại mật khẩu thất bại', [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back();
        }

        // Đăng xuất người dùng hiện tại
        Auth::logout();

        // Xóa cookie nếu đã lưu thông tin đăng nhập
        Cookie::queue(Cookie::forget('email'));
        Cookie::queue(Cookie::forget('password'));

        // Chuyển hướng lại trang đăng nhập
        return redirect()->route('auth.login-view');
    }

    private function generateSecurePassword($length = 8)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';

        // Đảm bảo mật khẩu có ít nhất 1 ký tự chữ in hoa, 1 ký tự đặc biệt
        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $specialChars[random_int(0, strlen($specialChars) - 1)];

        // Tạo phần còn lại của mật khẩu
        $allChars = $uppercase . $lowercase . $numbers . $specialChars;
        for ($i = 2; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Xáo trộn mật khẩu để tăng tính bảo mật
        return str_shuffle($password);
    }
    public function logout(Request $request)
    {
        // Đăng xuất người dùng hiện tại
        Auth::logout();

        // Xóa cookie nếu đã lưu thông tin đăng nhập
        Cookie::queue(Cookie::forget('email'));
        Cookie::queue(Cookie::forget('password'));

        // Thông báo đăng xuất thành công
        toastr("Bạn đã đăng xuất thành công", NotificationInterface::SUCCESS, "Đăng xuất", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        // Chuyển hướng về trang đăng nhập hoặc trang chủ
        return redirect()->route('auth.login-view');
    }
    public function changePassword(ChangePassRequest $request)
    {
        $user = Auth::user();
        // Kiểm tra nếu đã quá thời gian quy định để thay đổi mật khẩu (ví dụ: 30 ngày)
        $passwordChangeLimit = now()->subDays(30);
        if ($user->last_password_change && $user->last_password_change > $passwordChangeLimit) {
            return back()->withErrors(['new_password' => 'Bạn cần thay đổi mật khẩu sau 30 ngày.']);
        }
        // Kiểm tra nếu mật khẩu mới trùng với mật khẩu hiện tại
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.']);
        }
        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            // Khởi tạo số lần cố gắng đổi mật khẩu
            $attempts = session('password_change_attempts', 0) + 1;
            session(['password_change_attempts' => $attempts]);
            // Kiểm tra nếu đã vượt quá 5 lần cố gắng
            if ($attempts >= 5) {
                // Đặt trạng thái người dùng là IN_ACTIVE
                $user->update(['status' => 'IN_ACTIVE']); // Cập nhật trạng thái người dùng
                // Đăng xuất người dùng hiện tại
                Auth::logout();
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('password'));
                // Hiển thị thông báo khóa tài khoản
                sweetalert("Bạn đã nhập mật khẩu không chính xác 5 lần. Tài khoản đã bị khóa trong 15 phút.", NotificationInterface::ERROR, [
                    'position' => "center",
                    'timeOut' => '',
                    'closeButton' => false,
                ]);
                return redirect()->route('auth.login-view');
            }
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác. Bạn còn ' . (5 - $attempts) . ' lần thử']);
        }
        // Đặt lại số lần cố gắng
        session(['password_change_attempts' => 0]);
        // Cập nhật mật khẩu mới
        $user->update([
            'password' => Hash::make($request->new_password), // Sử dụng mật khẩu mới từ request
            'password_changed_at' => now(), // Cập nhật thời gian thay đổi mật khẩu
        ]);
        // Hiển thị thông báo thành công
        sweetalert("Thay đổi mật khẩu thành công", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);
        return back();
    }
}
