<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PermissionsMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles) {

         $user = Auth::user();

        /*
            Dentro da model de Grupo.

            private $roles = [
                1 => ['customer.index', 'category.index'],
                2 => ['customer.index'],
                3 => ['category.index']
            ]

            public function getRoles() {
                return $this->roles($this->id);
            }



            dd('entrou', $request->route()->getAction('role'));

            $user = Auth::user();

            dd($request->all());
            dd($roles);

            $data = [
                'customer' => true,
                'manager' => true,
                'employee' => true
            ];
            Session::put($data);
            // return $next($request);
        */



        foreach ($roles as $role) {

            if ($role == 'manager') {

                if (isset($user->manager_id)) {

                    $data = [
                        'manager' => true
                    ];
                    $request->session()->put($data);

                    return $next($request);

                } else {
                    return back()->with(Session::flash('error', 'Não possui permissão para acessar essa pagina'));
                }

            }

            if ($role == 'employee') {

                if (isset($user->employee_id)) {
                    $data = [
                        'employee' => true
                    ];

                    $request->session()->put($data);

                    return $next($request);

                } else if (isset($user->manager_id)) {
                    $data = [
                        'manager' => true
                    ];

                    $request->session()->put($data);

                    return $next($request);

                } else {
                    return back()->with(Session::flash('error', 'Não possui permissão para acessar essa página'));
                }

            }

            if ($role == 'customer') {

                if (isset($user->customer_id)) {
                    $data = [
                        'customer' => true
                    ];

                    if ($user->customer->is_new && !$request->is('person/'.$user->customer->person_id.'/edit') && !$request->rg) {
                        return redirect('person/'.$user->customer->person_id.'/edit');
                    }

                    $request->session()->put($data);

                    return $next($request);

                } else if (isset($user->manager_id)) {

                    $data = [
                        'manager' => true
                    ];

                    $request->session()->put($data);

                    return $next($request);

                } else if (isset($user->employee_id)) {

                    $data = [
                        'employee' => true
                    ];

                    $request->session()->put($data);

                    return $next($request);

                } else {

                    return back()->with(Session::flash('error', 'Não possui permissão para acessar essa página'));
                }

            }

            abort(403);
        }
    }
}
