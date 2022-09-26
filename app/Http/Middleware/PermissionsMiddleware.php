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
        */



        $userPermissions = array_filter([
            $user->customer_id ? "customer" : null,
            $user->employee_id ? "employee" : null,
            $user->manager_id ? "manager" : null
        ]);



        if (!array_diff($userPermissions, $roles)) {

            if ($user->customer_id) {

                if ($user->customer->is_new && !$request->is('person/'.$user->customer->person_id.'/edit') && !$request->rg) {

                    return redirect('person/'.$user->customer->person_id.'/edit');
                }

            }

            return $next($request);

        } else {

            return back()->with(Session::flash('error', 'Não possui permissão para acessar essa pagina'));
        }

    }
}
