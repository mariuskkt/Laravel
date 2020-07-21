@extends('layouts.app')

@section('content')
    @table([
        'header' =>
            [
                'name', 'surname', 'gender'
            ],
        'rows' =>
            [
                [
                    'donkis',
                    'isakas',
                    'asilas'
                ]
            ]
    ])
@endsection
