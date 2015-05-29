@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => $announcement->heading])

	<div class="list-inline">
		<li>
			{!! HTML::link_button(route('admin.announcements.edit', ['announcements' => $announcement->id]), trans('announcements.edit')) !!}
		</li>
		<li>
			{!! Form::open(['route' => ['admin.announcements.destroy.images', $announcement->id], 'method' => 'DELETE']) !!}
				{!! Form::button(e(trans('announcements.delete.image')), [
						'type' => 'submit',
						'class' => 'btn btn-primary',
						'data-toggle' => 'modal',
						'data-target' => '#delete-confirm'
					])
				!!}
			{!! Form::close() !!}
		</li>
	</div>
	<br>
	<div>
		{!! $announcement->content !!}
	</div>
	
	@if(null !== $announcement->image_ssn)
		@foreach($announcement->image_ssn as $image_ssn)
			@include('partials.image', ['image_ssn' => $image_ssn])
		@endforeach
	@endif
	
	@if(null !== $announcement->link)
		<span>
			{{ trans('announcements.link').'：' }}
			{!! HTML::link($announcement->link, null, ['target' => '_blank'])  !!}
		</span>
	@endif
	
	<span title="{{ $announcement->updated_at }}">{{ trans('announcements.updated_at').'：'.$announcement->updated_at->diffForHumans() }}</span>
	<span title="{{ $announcement->created_at }}">{{ trans('announcements.created_at').'：'.$announcement->created_at->diffForHumans() }}</span>
@stop