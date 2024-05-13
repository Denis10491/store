<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate ;
use Symfony\Component\HttpFoundation\Response;

class GateDefineMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            foreach (Permission::all() as $permission) {
                Gate::define($permission->name, function(Model $resource = null) use ($permission) {
                    if (isset($resource) && auth()->user()->id === $resource->user_id) {
                        return true;
                    }

                    if ($permission->roles()->where('roles.id', '=', auth()->user()->role_id)->exists()) {
                        return true;
                    }

                    return false;
                });
            }
        }

        return $next($request);
    }
}
