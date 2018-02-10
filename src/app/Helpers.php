<?php

function getWordsStartsWith($letter = 'a') {
  $words = AbbyJanke\BackpackDictionary\app\Models\Dictionary::get();

  $returnable = [];
  foreach($words as $word) {
    if (substr($word->word, 0, 1) === lcfirst($letter) OR substr($word->word, 0, 1) === ucfirst($letter)) {
      $returnable[] = $word;
    }
  }

  return $returnable;
}
