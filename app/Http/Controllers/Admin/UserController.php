<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\user\StoreUserRequest;
use App\Http\Requests\Admin\user\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('roles')->latest('id')->paginate(5);

        return view('admin.pages.user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();

        return view('admin.pages.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();

        try {
            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('users', $request->file('image'));
            }

            $user =  User::query()->create($data);

            $user->roles()->sync($data['roles']); // đồng bộ

            toastr("Thêm mới người dùng thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            toastr("Thêm mới người dùng thất bại", NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id')->all();
        // dd($user);
        return view('admin.pages.user.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->all();

        try {
            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('users', $request->file('image'));
            }

            $imagePath = $user->image;

            $user->update($data);

            $user->roles()->sync($data['roles']);

            if (
                $request->hasFile('image')
                && !empty($imagePath)
                && Storage::exists($imagePath)
            ) {
                Storage::delete($imagePath);
            }

            toastr("Cập nhật người dùng thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            toastr("Cập nhật người dùng thất bại", NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->roles()->detach();

            $imagePath = $user->image;

            $user->delete();

            if (!empty($imagePath) && Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            toastr("Xoá người dùng thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            toastr("Xoá người dùng thất bại", NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
        }
    }
}
