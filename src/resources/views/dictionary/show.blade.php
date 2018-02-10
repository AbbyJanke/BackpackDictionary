@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('backpack::dictionary.define'): {{ $word->word }}</div>

                <div class="panel-body">
                  <nav aria-label="Page navigation">
                    <ul class="list-unstyled">
                      <li><strong>@choice('backpack::dictionary.definition', 1):</strong>
                        <br />{{ $word->definition }}
                      </li>
                      @php
                        $relatedBas = $word->related()->get();
                        $relatedSyn = $word->related('synonym')->get();
                        $relatedAnt = $word->related('antonym')->get();
                      @endphp

                      @if(count($relatedSyn))
                      <li style="margin:15px 0;border-bottom:1px solid rgba(0,0,0,0.1);padding-bottom:15px;"><strong>@choice('backpack::dictionary.synonym', 2):</strong>
                        <ul>
                          @foreach($relatedSyn as $word)
                            <li><a href="{{ route('dictionary.show', ['slug' => $word->slug])}}">{{ $word->word }}</a></li>
                          @endforeach
                        </ul>
                      </li>
                      @endif

                      @if(count($relatedAnt))
                      <li style="margin:15px 0;border-bottom:1px solid rgba(0,0,0,0.1);padding-bottom:15px;"><strong>@choice('backpack::dictionary.antonym', 2):</strong>
                        <ul>
                          @foreach($relatedAnt as $word)
                            <li><a href="{{ route('dictionary.show', ['slug' => $word->slug])}}">{{ $word->word }}</a></li>
                          @endforeach
                        </ul>
                      </li>
                      @endif

                      @if(count($relatedBas))
                      <li style="margin:15px 0;border-bottom:1px solid rgba(0,0,0,0.1);padding-bottom:15px;"><strong>@lang('backpack::dictionary.related'):</strong>
                        <ul>
                          @foreach($relatedBas as $word)
                            <li><a href="{{ route('dictionary.show', ['slug' => $word->slug])}}">{{ $word->word }}</a></li>
                          @endforeach
                        </ul>
                      </li>
                      @endif

                      <li><strong>@choice('backpack::dictionary.last_update', 2):</strong> {{ $word->updated_at }}</li>
                    </ul>
                  </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
