<?php

namespace App\Http\Controllers;

use App\Bike;
use App\UserBike;
use App\UserBikes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bikes = UserBike::all();
        $user_bikes = $bikes->where('user_id', Auth::id());

        $table = [
            'attr' => [
                'class' => 'table-bikes-show'],
            'header' =>
                [
                    'Manufacturer', 'Description', 'City', 'Photo', 'Price €', 'Action'
                ],
            'rows' => []
        ];
        $table['rows'] = [];
        foreach ($user_bikes as $user_bike) {
            $table['rows'][] = [
                $user_bike->title,
                $user_bike->description,
                $user_bike->city,
                view('components/img', [
                    'class' => 'img-bikes-show-table',
                    'src' => $user_bike->photo
                ]),
                $user_bike->price,
                view('components/a', [
                    'href' => route('userbikes.edit', $user_bike->id),
                    'name' => 'EDIT'
                ]),
                view('components/form', [
                        'attributes' => [
                            'action' => route('userbikes.destroy', $user_bike->id)
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
                    ]
                )
            ];
        }
        return view('bikes_show', ['table' => $table, 'h1'=>'Bikes you have listed']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = [
            'attributes' => [
                'action' => route('userbikes.store'),
                'class' => 'form-custom-style'
            ],
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'label' => 'Bike manufacturer: '
                ],
                'description' => [
                    'type' => 'textarea',
                    'value' => '',
                    'label' => 'Description: '
                ],
                'city' => [
                    'type' => 'text',
                    'label' => 'City: '
                ],
                'photo' => [
                    'type' => 'text',
                    'label' => 'Photo URL: '
                ],
                'price' => [
                    'type' => 'number',
                    'label' => 'Price: '
                ]
            ],
            'buttons' => [
                'submit' => [
                    'title' => 'Submit'
                ]
            ]
        ];
        return view('bikes_create', ['form' => $form, 'h1'=>'Add your bike for rent']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bike = new UserBike($request->all());
        $bike->user_id = Auth::id();
        $bike->save();
        return redirect('userbikes');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\UserBikes $userBikes
     * @return \Illuminate\Http\Response
     */
    public function show(UserBike $userbike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UserBikes $userBike
     * @return \Illuminate\Http\Response
     */
    public function edit(UserBike $userbike)
    {
        $form = [
            'attributes' => [
                'action' => route('userbikes.update', $userbike->id),
                'class' => 'form-custom-style'
            ],
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'label' => 'Bike manufacturer: ',
                    'value' => $userbike->title
                ],
                'description' => [
                    'type' => 'textarea',
                    'value' => $userbike->description,
                    'label' => 'Description: '
                ],
                'city' => [
                    'type' => 'text',
                    'value' => $userbike->city,
                    'label' => 'City: '
                ],
                'photo' => [
                    'type' => 'text',
                    'value' => $userbike->photo,
                    'label' => 'Photo URL: '
                ],
                'price' => [
                    'type' => 'number',
                    'value' => $userbike->price,
                    'label' => 'Price: '
                ],
                '_method' => [
                    'type' => 'hidden',
                    'value' => 'PUT'
                ]
            ],
            'buttons' => [
                'submit' => [
                    'title' => 'Update'
                ]
            ]
        ];
        return view('bikes_create', ['form' => $form, 'h1'=>'Edit info about your bike']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param UserBike $userBike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserBike $userbike)
    {
        $userbike->title = $request->input('title');
        $userbike->description = $request->input('description');
        $userbike->city = $request->input('city');
        $userbike->photo = $request->input('photo');
        $userbike->price = $request->input('price');
        $userbike->save();
        return redirect('userbikes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserBike $userbike
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(UserBike $userbike)
    {
        $userbike->delete();
        return redirect('userbikes');
    }
}
