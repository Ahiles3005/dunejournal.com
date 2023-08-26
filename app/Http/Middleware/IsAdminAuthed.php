<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminAuthed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ( !empty( session('admin_authed') ) ) {
            session(['admin_authed' => true]);
            return $next($request);
        }

        if( $request->ajax() ) return jsonResponse( ['error' => 'Доступ без авторизации недоступен!'] );

        return redirect()->route('admin.page.index')->withErrors( ['message' => 'Доступ без авторизации недоступен!'] );
    }
}
