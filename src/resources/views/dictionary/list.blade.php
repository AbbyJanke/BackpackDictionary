@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
      <div class="col-md-2 col-md-offset-1">
        <ul class="list-group">
          @foreach($letters as $letter)
            <?php $words = getWordsStartsWith($letter); ?>
            @if(count($words))
              <a href="#@lang('backpack::dictionary.'.$letter)" class="list-group-item text-center">@lang('backpack::dictionary.'.$letter)</a>
            @else
              <span class="list-group-item text-center" style="background:rgba(0,0,0,0.015);cursor: not-allowed;">@lang('backpack::dictionary.'.$letter)</span>
            @endif
          @endforeach
        </ul>
      </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('backpack::dictionary.dictionary')</div>

                <div class="panel-body">
                  <nav aria-label="Page navigation">
                    <ul class="list-unstyled">
                      @foreach($letters as $letter)
                        <?php $words = getWordsStartsWith($letter); ?>
                        @if(count($words))
                          <li style="border-bottom: 1px solid rgba(0,0,0,0.14);margin-bottom: 15px;" id="{{ $letter }}"><span id="#{{ $letter }}" style="font-size:1.5em;"><strong>{{ $letter }}</strong></span>
                            <ul style="margin-bottom:15px;">
                              @foreach($words as $word)
                                <li><a href="{{ route('dictionary.show', ['slug' => $word->slug])}}">{{ $word->word }}</a></li>
                              @endforeach
                            </ul>
                          </li>
                        @endif
                      @endforeach
                    </ul>
                  </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
