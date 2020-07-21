<?php


namespace App\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

trait AddsNavigation
{
    public function addNavigation()
    {
        $this->middleware(function ($request, $next) {
            $nav = [
                'left' => [
                    [
                        'url' => route('bikes.index'),
                        'name' => 'All bikes'
                    ]
                ],

                'right' => [
                    [
                        'url' => route('test'),
                        'name' => 'Test'
                    ],
                    [
                        'url' => route('login'),
                        'name' => 'Login',
                    ]
                ]

            ];

            if (Auth::user()) {
                $nav['left'] = [
                    [
                        'url' => route('bikes.index'),
                        'name' => 'All bikes'
                    ],
                    [
                        'url' => route('userbikes.create'),
                        'name' => 'Add a bike for rent'
                    ]
                ];
                $nav['right']['dropdown'][] = [
                    'url' => route('userbikes.index'),
                    'name' => 'My bikes'
                ];
                $nav['right']['dropdown'][] = [
                    'url' => route('logout'),
                    'name' => 'Logout'
                ];
            };

            if (Route::has('register')) {
                $nav['register'][] =
                    [
                        'url' => route('register'),
                        'name' => 'Register'
                    ];
            }

            View::share('nav', $nav);
            return $next($request);
        });
    }
}
