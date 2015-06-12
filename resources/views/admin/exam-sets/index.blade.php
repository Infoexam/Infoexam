@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-sets.list')])

    <div>
        <a href="{{ route('admin.exam-sets.create') }}">
            <button class="btn btn-primary">{{ trans('exam-sets.create') }}</button>
        </a>
    </div>
    <br>
    <div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>{{ trans('exam-sets.name') }}</th>
                    <th>{{ trans('exam-sets.category') }}</th>
                    <th>{{ trans('exam-sets.set_enable') }}</th>
                    <th>{{ trans('exam-sets.open_practice') }}</th>
                    <th class="hidden-xs">{{ trans('exam-questions.create') }}</th>
                    <th class="hidden-xs">{{ trans('exam-sets.edit') }}</th>
                    <th class="hidden-xs">{{ trans('exam-sets.delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exam_sets as $exam_set)
                    <tr>
                        <td>{!! HTML::linkRoute('admin.exam-sets.show', $exam_set->name, ['exam_sets' => $exam_set->ssn]) !!}</td>
                        <td>{{ ('A' === $exam_set->category) ? trans('exam-sets.application') : trans('exam-sets.software') }}</td>
                        <td>{!! HTML::true_or_false($exam_set->set_enable) !!}</td>
                        <td>{!! HTML::true_or_false($exam_set->open_practice) !!}</td>
                        <td class="hidden-xs">{!! HTML::create_icon(route('admin.exam-questions.create', ['ssn' => $exam_set->ssn])) !!}</td>
                        <td class="hidden-xs">{!! HTML::edit_icon(route('admin.exam-sets.edit', ['ssn' => $exam_set->ssn])) !!}</td>
                        <td class="hidden-xs">
                            @include('partials.delete-form', ['route' => ['admin.exam-sets.destroy', $exam_set->ssn]])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {!! $exam_sets->appends(Request::query())->render() !!}
    </div>
@stop