<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\Http\Requests\AchievementRequest;
use App\User;
use CreateUsersAchievementsTableCreate;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use phpDocumentor\Reflection\Location;

class AchievementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $achievements = Achievement::all()->sortBy('id');
        $table = [
            'header' =>
                [
                    'id', 'title', 'description', 'points', 'edit', 'delete'
                ],
            'rows' =>
                [
                ]
        ];
        foreach ($achievements as $achievement) {
            $table['rows'][] = [
                $achievement->id,
                $achievement->title,
                $achievement->description,
                $achievement->points,
                view('components/a', [
                    'href' => route('achievements.edit', $achievement->id),
                    'name' => 'EDIT'
                ]),
                view('components/form', [
                    'attributes' => [
                        'action' => route('achievements.destroy', $achievement->id)
                    ],
                    'fields' => [
                        '_method' => [
                            'type' => 'hidden',
                            'value' => 'DELETE'
                        ]
                    ],
                    'buttons' => [
                        'delete' => [
                            'title' => 'Delete'
                        ]
                    ]
                ])
            ];
        }
        return view('achievements', ['table' => $table]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        $form = [
            'attributes' => [
                'action' => '/achievements',
                'class' => 'form-custom-style'
            ],
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'label' => 'Title: '
                ],
                'description' => [
                    'type' => 'text',
                    'label' => 'Description: '
                ],
                'points' => [
                    'type' => 'number',
                    'label' => 'Points: '
                ],
                'select' => [
                    'extra' => [
                        'attr' => [
                            'multiple' => true
                        ]
                    ],
                    'type' => 'select',
                    'label' => 'Select user: ',
                    'value' => [],
                    'options' => [
                    ],
                ]
            ],
            'buttons' => [
                'submit' => [
                    'title' => 'Submit'
                ]
            ]
        ];

        foreach ($users as $user) {
            $form['fields']['select']['options'][$user->id] = $user->name;
        }

        return view('components/form',
            $form);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AchievementRequest $request)
    {
        $achievement = new Achievement($request->all());
        $achievement->save();
        $achievement->users()->attach($request->input('select'));
        return redirect('achievements');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function show(Achievement $achievement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function edit(Achievement $achievement)
    {
        dd($achievement);
        $selected_users = Achievement::find($achievement->id)->users;
        dd($selected_users);
        $all_users = User::all();
        $form = [
            'attributes' => [
                'action' => route('achievements.update', $achievement->id)
            ],
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'label' => 'Title: ',
                    'value' => $achievement->title
                ],
                'description' => [
                    'type' => 'text',
                    'label' => 'Description: ',
                    'value' => $achievement->description

                ],
                'points' => [
                    'type' => 'number',
                    'label' => 'Points: ',
                    'value' => $achievement->points
                ],
                'select' => [
                    'extra' => [
                        'attr' => [
                            'multiple' => true
                        ]
                    ],
                    'type' => 'select',
                    'label' => 'Select user: ',
                    'value' => [

                    ],
                    'options' => [

                    ]
                ],
                '_method' => [
                    'type' => 'hidden',
                    'value' => 'PUT'
                ]
            ],
            'buttons' => [
                'edit' => [
                    'title' => 'Edit'
                ]
            ]
        ];

        foreach ($all_users as $user) {
            $form['fields']['select']['options'][$user->id] = $user->name;
        }
        foreach ($selected_users as $user) {
            $user_id = $user->pivot->user_id;
            $form['fields']['select']['value'][] = $user_id;
        }

        return view('components/form',
            $form);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function update(AchievementRequest $request, Achievement $achievement)
    {
        $achievement->title = $request->input('title');
        $achievement->description = $request->input('description');
        $achievement->points = $request->input('points');
        $achievement->users()->sync($request->input('select'));
        $achievement->save();
        return redirect('achievements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Achievement $achievement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();
        return redirect('achievements');
    }
}
