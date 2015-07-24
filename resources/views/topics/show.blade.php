@extends('layouts.app')

@section('title')
    {{ trans('topic.Topic') }}: {{ $topic->title }} - @parent
@endsection

@section('content')
<!-- Topic -->
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-default section-panel-topic">
                <div class="panel-heading topic-header">
                    <div class="avatar pull-left">
                        <img src="{{ $topic->author->avatar }}">
                    </div>
                    <span class="title">
                        {{ $topic->title }}
                    </span>
                    <div class="info">
                        <a href="#">{{ $topic->author->name }}</a>
                        <span class="nodeName">{{ $topic->category->name }}</span>
                        <span class="separator">|</span>
                        <span>{{ timeAgo($topic->updated_at) }}</span>
                        <span class="separator">|</span>
                        <span>{{ trans('topic.ReplyCount', ['count' => $topic->comment_count]) }}</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    {!! nl2br($topic->body) !!}

                    <hr>
                    <div class="" style="margin-top:-10px">
                        <span>{{ trans('app.Share') }}</span> &nbsp;
                        <a><i class="fa fa-twitter"></i></a>
                        <a><i class="fa fa-facebook"></i></a>
                        <a><i class="fa fa-weibo"></i></a>

                        <div class="pull-right">
                            <a href="#anchor-reply"><i class="fa fa-reply"></i> {{ trans('topic.Reply') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--  -->
            <div class="panel panel-default section-items-reply">
                <div class="panel-heading">{{ trans('topic.replys') }}</div>
                <div class="panel-body">
                    @if (!$topic->comment_count)
                        <span>{{ trans('topic.no replys') }}</span>
                    @endif
                    @foreach ($topic->comments as $comment)
                        <div class="item-reply">
                            <div class="avatar pull-left">
                                <img src="{{ $comment->author->avatar }}">
                            </div>
                            <div class="body">
                                <div class="info">
                                    <a>{{ $comment->author->name }}</a>
                                    <span class="separator">|</span>
                                    <span>{{ date('Y-m-d', $comment->create_at) }}</span>
                                </div>
                                <div class="content">
                                    {!! nl2br($comment->body) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel panel-default">
                <div id="anchor-reply" class="panel-heading">{{ trans('topic.My Reply') }}</div>
                <div class="panel-body">
                    @if (Auth::guest())
                        <div>
                            {{ trans('app.Please') }}<a href="{{ url('auth/login') }}">{{ trans('app.Login') }}</a>
                        </div>
                    @else
                        {!! Form::open(['url' => '/reply', 'class' => '']) !!}
                            {!! Form::hidden('topic_id', $topic->id) !!}
                            <div class="form-group {{ $errors->has('body') ? 'has-error' : ''  }}">
                                {!! Form::textarea('body', '', ['class' => 'form-control', 'rows' => '3']) !!}
                                <p class="help-block help-block-error">{{ $errors->first('body') }}</p>
                            </div>
                            <div class="from-group text-right">
                                {!! Form::submit(trans('app.Submit'), ['class' => 'btn btn-default']) !!}
                            </div>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
         </div>

        <div class="col-sm-4">
            @include('snippets.panel-topicSide')
        </div>
    </div>
</div>


<!-- Category  -->
@include('snippets.panel-category')

@endsection