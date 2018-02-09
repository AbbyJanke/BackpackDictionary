<?php namespace AbbyJanke\BackpackDictionary\app\Http\Controllers;

use App\Http\Controllers\Controller;

use AbbyJanke\BackpackDictionary\app\Models\Dictionary;

class DictionaryController extends Controller
{
    private $data = [];

    /**
     * Display a blog article page.
     *
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['definitions'] = Dictionary::orderBy('word', 'asc')->get();

        dd($data['definitions']);
        return view('blog::author', $this->data);
    }
}
