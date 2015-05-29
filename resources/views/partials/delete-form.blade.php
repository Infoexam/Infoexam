{!! Form::open(['route' => $route, 'method' => 'DELETE']) !!}
    {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', [
            'type' => 'submit',
            'title' =>  trans('general.delete'),
            'class' => 'btn btn-default btn-lg',
            'data-toggle' => 'modal',
            'data-target' => '#delete-confirm'
        ])
    !!}
{!! Form::close() !!}