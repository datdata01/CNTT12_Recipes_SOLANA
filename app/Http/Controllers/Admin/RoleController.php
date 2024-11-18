<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\role\StoreRoleRequest;
use App\Http\Requests\Admin\role\UpdateRoleRequest;
use App\Models\Role;
use Flasher\Prime\Notification\NotificationInterface;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::latest('id')->paginate(5);

        return view('admin.pages.roles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $data = $request->all();
        // dd($data);
        try {
            Role::query()->create($data);

            toastr("Thêm mới vai trò thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            toastr("Thêm mới vai trò thành công", NotificationInterface::ERROR, "Thất bại", [
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
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.pages.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $request->all();
        // dd($data);
        try {
            $role->update($data);

            toastr("Cập nhật vai trò thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            toastr("Cập nhật vai trò thất bại", NotificationInterface::ERROR, "Thất bại", [
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
    public function destroy(Role $role)
    {
        try {
            $role->delete();

            toastr("Xoá vai trò thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            toastr("Xoá vai trò thất bại", NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);
            return back();
        }
    }
}
