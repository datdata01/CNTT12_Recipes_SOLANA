<?php

namespace App\Http\Controllers\Admin;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\attributes\AttributeRequest;
use App\Http\Requests\Admin\attributes\UpdateAttributeRequest;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Database\QueryException;

class AttributeController extends Controller
{
    public function index()
    {
        $attribute =  Attribute::query()
            ->orderBy('id', 'asc')
            ->paginate(12);

        return view("admin.pages.attributes.attribute.index",['attribute' => $attribute]);
    }

    public function store(AttributeRequest $request)
    {
        Attribute::insert([
            'name' => $request->name,
        ]);

        toastr("Chúc mừng bạn thêm mới thành công ", NotificationInterface::SUCCESS, "Thêm mới thành công ", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('attributes.index');
    }

    public function edit(string $id)
    {
        $attribute = Attribute::find($id);
        return view("admin.pages.attributes.attribute.update", compact('attribute'));
    }

    public function update(UpdateAttributeRequest $request, string $id)
    {
        $attribute = Attribute::find($id);
        $attribute->update([
            'name' => $request->name,
        ]);
        toastr("Chúc mừng bạn cập nhật mới thành công ", NotificationInterface::SUCCESS, "Cập nhật thành công ", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('attributes.index');
    }

    public function destroy(string $id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->delete();
            toastr("Thuộc tính đã được xóa thành công!", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back();
        } catch (QueryException $exception) {
            toastr("Không thể xóa thuộc tính này do đã được sử dụng!", NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back();
        }
    } 
}
