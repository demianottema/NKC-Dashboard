<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Filament\Resources\Groups\GroupResource;

class FilamentGroupRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Whitelisted pages
        $whitelistedPatterns = [
            '/dashboard',
        ];

        // Check if the user is logged in
        if (!Auth::check()) {
            return $next($request);
        }

        $group = $request->user()->groups->first();
        if ($request->user()->groups->count() === 1 && $group) {
            // Add the current path to the whitelist
            $whitelistedPatterns[] = '/groups/'.$group->id;
            
            // Get the target path, and the 
            $targetPath = ltrim(parse_url(GroupResource::getUrl('sections', ['record' => $group]), PHP_URL_PATH), '/');
            $currentPath = $request->path();

            // Get the current filament path
            $filamentPath = Filament::getDefaultPanel()->getPath();

            foreach ($whitelistedPatterns as $pattern) {
                if (Str::is($filamentPath.$pattern, $currentPath)) {
                    return $next($request);
                }
            }

            if ($currentPath !== $targetPath) {
                return redirect(GroupResource::getUrl('sections', ['record' => $group]));
            }
        }

        return $next($request);
    }
}
