<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ManagementInterface;
use App\Models\Categories;
use App\Models\NewsCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Cocur\Slugify\Slugify;

class CategoriesController extends Controller implements ManagementInterface
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index()
    {
        return view('admin.categories', [
            'categories' => Categories::orderBy('id', 'desc')->get()
        ]);
    }

    public function info()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return jsonResponse(['error' => concatErrors($validator->errors()->getMessages())]);
        }

        $category = Categories::find($this->request->id);
        if ($category == null) {
            return jsonResponse(['error' => 'Тематика не существует!']);
        }

        return jsonResponse($category);
    }

    public function delete()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => ['required', 'numeric', 'min:1'],
        ]);

        if ($validator->fails()) {
            return jsonResponse(['error' => concatErrors($validator->errors()->getMessages())]);
        }

        $category = Categories::find($this->request->id);
        if ($category == null) {
            return jsonResponse(['error' => 'Тематика не существует!']);
        }

        $deleted = $category->delete();
        if ($deleted) {
            NewsCategories::where('category_id', $this->request->id)->delete();
            return jsonResponse(['success' => 'Вы успешно удалили тематику!']);
        }

        return jsonResponse(['error' => 'Не удалось удалить тематику!']);
    }

    public function add()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => ['required', 'string', 'min:1', 'max:100'],
        ], [], [
            'name' => 'Название',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = $this->request->all();

        if (empty($data['slug'])) {
            $slugify = new Slugify();
            $data['slug'] = $slugify->slugify($data['name']);
        }

        $saved = Categories::create($data);
        if ($saved) {
            return back()->with('success', 'Вы успешно создали тематику!');
        }

        return back()->withErrors(
            ['error' => 'Не удалось создать тематику. Перепроверьте входные данные и повторите попытку!']
        );
    }

    public function edit()
    {
        $validator = Validator::make($this->request->all(), [
            'id' => ['required', 'numeric', 'min:1'],
            'name' => ['required', 'string', 'min:1', 'max:100'],
        ], [], [
            'name' => 'Название',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }


        $category = Categories::find($this->request->id);
        if ($category == null) {
            return back()->withErrors(['error' => 'Тематика не существует для редактирования!']);
        }

        $data = $this->request->all();

        if (empty($data['slug'])) {
            $slugify = new Slugify();
            $data['slug'] = $slugify->slugify($data['name']);
        }

        $updated = $category->fill($data)->save();

        if ($updated) {
            return back()->with('success', 'Вы успешно отредактировали тематику!');
        }

        return back()->withErrors(
            ['error' => 'Не удалось отредактировать тематику. Перепроверьте входные данные и повторите попытку!']
        );
    }
}
