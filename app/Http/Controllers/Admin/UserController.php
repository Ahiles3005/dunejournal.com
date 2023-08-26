<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(Request $request){
        parent::__construct($request);
    }

    public function indexPage(){
        return view('admin.index');
    }

    public function auth(){
        $validator = Validator::make($this->request->all(), [
            'login' => ['required', 'string', 'min:1', 'max:100'],
            'pass' => ['required', 'string', 'min:1'],
        ]);

        if( $validator->fails() ) return back()->withErrors($validator);

        if( strcmp($this->request->login, env('ADMIN_LOGIN')) === 0 && strcmp($this->request->pass, env('ADMIN_PASS')) === 0 ){
            session(['admin_authed' => true]);
            return redirect()->route('admin.page.index');
        }

        return back()->withErrors('Не удалось авторизоваться в админ-панели. Проверьте данные автентификации!');
    }

    public function logout(){
        session()->forget('admin_authed');
        return redirect()->route('admin.page.index');
    }
}
