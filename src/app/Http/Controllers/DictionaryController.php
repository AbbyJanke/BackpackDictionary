<?php namespace AbbyJanke\BackpackDictionary\app\Http\Controllers;

use App\Http\Controllers\Controller;

use AbbyJanke\BackpackDictionary\app\Models\Dictionary;

class DictionaryController extends Controller
{
    private $data = [];

    /**
     * Display a list of all words within the dictionary.
     *
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['definitions'] = Dictionary::orderBy('word', 'asc')->get();
        $data['letters'] = range('A', 'Z');

        return view('dictionary::list', $data);
    }

    public function show($slug) {

      $data['word'] = Dictionary::findBySlug($slug);

      return view('dictionary::show', $data);

    }


}
