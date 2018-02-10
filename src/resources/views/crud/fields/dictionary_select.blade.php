<?php
$related = \DB::table('dictionary_related')->where('parent_id', $id)->get();
$relatedID = [];
?>


<!-- select multiple -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <select
    	class="form-control"
        name="{{ $field['name'] }}[]"
        @include('crud::inc.field_attributes')
    	multiple>

		@if (!isset($field['allows_null']) || $field['allows_null'])
			<option value="">-</option>
		@endif

    @foreach($related as $pivots)
      @if($pivots->relationship == $field['name'])
        <?php $relatedID[] = $pivots->child_id; ?>
        <option value="{{ $pivots->child_id }}" selected>{{ AbbyJanke\BackpackDictionary\app\Models\Dictionary::find($pivots->child_id)->word }}</option>
      @endif
    @endforeach

    @if (isset($field['model']))
      @foreach ($field['model']::all() as $connected_entity_entry)
        @if(in_array($connected_entity_entry->getKey(), $relatedID) OR $connected_entity_entry->getKey() == $id)
          <?php continue; ?>
        @endif
        <option value="{{ $connected_entity_entry->getKey() }}">{{ $connected_entity_entry->{$field['attribute']} }}</option>
      @endforeach
    @endif
	</select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
