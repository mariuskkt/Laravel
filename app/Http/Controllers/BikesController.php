<?php

namespace App\Http\Controllers;

use App\Bike;
use App\User;
use App\UserBike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Nullable;

class BikesController extends Controller
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
        $bikes = UserBike::all()->sortBy('id');
        $cards = [];
        foreach ($bikes as $bike) {
            if ($bike->user_id != Auth::id()) {
                $cards[$bike->id] = [
                    'photo' => $bike->photo,
                    'title' => $bike->title,
                    'description' => $bike->description,
                    'city' => $bike->city,
                    'more' => view('components/a', [
                        'href' => route('bikes.show', $bike->id),
                        'name' => 'More'
                    ])
                ];
            }
        }
        return view('bikes', ['cards' => $cards]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param Bike $bike
     * @return void
     */
    public function show(Bike $bike)
    {
        $current_bike = UserBike::find($bike->id);
        $table = [
            'attr' => [
                'class' => 'table-bikes-show'],
            'header' =>
                [
                    'Manufacturer', 'Description', 'City', 'Photo', 'Price €', 'Action'
                ],
            'rows' =>
                [
                ]
        ];
        $table['rows'][] = [
            $current_bike->title,
            $current_bike->description,
            $current_bike->city,
            view('components/img', [
                'class' => 'img-bikes-show-table',
                'src' => $current_bike->photo
            ]),
            $current_bike->price,
            view('components/form', [
                'buttons' => [
                    'order' => [
                        'title' => 'Make an offer',
                        'extra' => [
                            'attr' => [
                                'class' => 'offer-button']
                        ]
                    ]
                ]])
        ];
        return view('bikes_show', ['table' => $table, 'h1'=>'Just make a deal']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Bike $bike
     * @return \Illuminate\Http\Response
     */
    public function edit(Bike $bike)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Bike $bike
     * @return void
     */
    public function update(Request $request, Bike $bike)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bike $bike
     * @return void
     */
    public function destroy(Bike $bike)
    {
        //
    }
}
