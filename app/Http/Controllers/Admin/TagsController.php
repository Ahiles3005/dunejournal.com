<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ManagementInterface;
use App\Models\NewsTags;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller implements ManagementInterface
{
    public function __construct(Request $request){
        parent::__construct($request);
    }

    public function index(){
        return view('admin.tags', [
            'tags' => Tags::orderBy('id', 'desc')->get()
        ]);
    }

    public function info(){
        $validator = Validator::make($this->request->all(), [
            'id' => ['required', 'numeric']
        ]);

        if( $validator->fails() ) return jsonResponse( ['error' => concatErrors( $validator->errors()->getMessages() ) ] );

        $tag = Tags::find($this->request->id);
        if($tag == null) return jsonResponse( ['error' => 'Тэг не существует!'] );

        return jsonResponse($tag);
    }

    public function delete(){
        $validator = Validator::make($this->request->all(), [
            'id' => ['required', 'numeric', 'min:1'],
        ]);

        if( $validator->fails() ) return jsonResponse( ['error' => concatErrors( $validator->errors()->getMessages() ) ] );

        $tag = Tags::find($this->request->id);
        if($tag == null) return jsonResponse( ['error' => 'Тэг не существует!'] );

        $deleted = $tag->delete();
        if($deleted) {
            NewsTags::where('tag_id', $this->request->id)->delete();
            return jsonResponse(['success' => 'Вы успешно удалили тэг!']);
        }

        return jsonResponse( ['error' => 'Не удалось удалить тэг!'] );
    }

    public function add(){
        $validator = Validator::make($this->request->all(), [
            'hover_color' => ['required', 'string', 'min:1', 'max:100'],
            'name' => ['required', 'string', 'min:1', 'max:100'],
            'is_hot' => ['required'],
        ], [], [
            'name' => 'Название',
            'hover_color' => 'Цвет при наведении',
            'is_hot' => 'Отображать как главной?',
        ]);

        if( $validator->fails() ) return back()->withErrors($validator);

        $saved = Tags::create( $this->request->all() );
        if($saved) return back()->with('success', 'Вы успешно создали тэг!');

        return back()->withErrors(['error' => 'Не удалось создать тэг. Перепроверьте входные данные и повторите попытку!']);
    }

    public function edit(){
        $validator = Validator::make($this->request->all(), [
            'id' => ['required', 'numeric', 'min:1'],
            'name' => ['required', 'string', 'min:1', 'max:100'],
            'hover_color' => ['required', 'string', 'min:1', 'max:100'],
            'is_hot' => ['required'],
        ], [], [
            'name' => 'Название',
            'hover_color' => 'Цвет при наведении',
            'is_hot' => 'Отображать как главной?',
        ]);

        if( $validator->fails() ) return back()->withErrors($validator);

        $tag = Tags::find($this->request->id);
        if($tag == null) return back()->withErrors(['error' => 'Тэг не существует для редактирования!']);

        $updated = $tag->fill( $this->request->all() )->save();

        if($updated) return back()->with('success', 'Вы успешно отредактировали тэг!');

        return back()->withErrors(['error' => 'Не удалось отредактировать тэг. Перепроверьте входные данные и повторите попытку!']);
    }
}
