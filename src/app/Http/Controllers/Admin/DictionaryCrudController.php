<?php namespace AbbyJanke\BackpackDictionary\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use DB;
use AbbyJanke\BackpackDictionary\app\Models\Dictionary;

// VALIDATION: change the requests to match your own file names if you need form validation
use AbbyJanke\BackpackDictionary\app\Http\Requests\DictionaryCrudRequest as StoreRequest;
use AbbyJanke\BackpackDictionary\app\Http\Requests\DictionaryCrudRequest as UpdateRequest;

class DictionaryCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('AbbyJanke\BackpackDictionary\app\Models\Dictionary');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/dictionary');
        $this->crud->setEntityNameStrings('definition', 'definitions');

        $this->crud->addColumn([
          'name' => 'id',
          'label' => __('backpack::dictionary.id'),
        ]);
        $this->crud->addColumn([
          'name' => 'word',
          'label' => __('backpack::dictionary.word'),
        ]);
        $this->crud->addColumn([
          'name' => 'definition',
          'label' => trans_choice('backpack::dictionary.definition', 1),
        ]);

        $this->crud->addField([
          'name' => 'word',
          'label' => __('backpack::dictionary.word'),
          'type' => 'text',
          ]);
        $this->crud->addField([
          'name' => 'slug',
          'label' => __('backpack::dictionary.slug'),
          'type' => 'text',
          'hint' => __('backpack::dictionary.slug_helper'),
          ]);
        $this->crud->addField([
          'name' => 'definition',
          'label' => trans_choice('backpack::dictionary.definition', 1),
          'type' => 'textarea',
          ]);
        $this->crud->addField([
            'label' => trans_choice('backpack::dictionary.synonym', 2),
            'type' => 'dictionary_select',
            'name' => 'synonym',
            'attribute' => 'word',
            'model' => "AbbyJanke\BackpackDictionary\app\Models\Dictionary",
        ]);
        $this->crud->addField([
            'label' => trans_choice('backpack::dictionary.antonym', 2),
            'type' => 'dictionary_select',
            'name' => 'antonym',
            'attribute' => 'word',
            'model' => "AbbyJanke\BackpackDictionary\app\Models\Dictionary",
        ]);
        $this->crud->addField([
            'label' => trans_choice('backpack::dictionary.related', 2),
            'type' => 'dictionary_select',
            'name' => 'basic',
            'attribute' => 'word',
            'model' => "AbbyJanke\BackpackDictionary\app\Models\Dictionary",
        ]);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @param StoreRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request = null)
    {
        $this->crud->hasAccessOrFail('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ($request->input() as $key => $value) {
            if (empty($value) && $value !== '0') {
                $request->request->set($key, null);
            }
        }

        // insert item in the db
        $item = $this->crud->create($request->except(['save_action', '_token', '_method']));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }

    public function update(UpdateRequest $request)
    {
        $this->crud->hasAccessOrFail('update');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ($request->input() as $key => $value) {
            if (empty($value) && $value !== '0') {
                $request->request->set($key, null);
            }
        }

        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
                            $request->except('save_action', '_token', '_method'));

        $deleteRelated = DB::table('dictionary_related')->where('parent_id', $item->id)->delete();


        $syncArray = [];

        if($request->has('synonym')) {
          foreach($request->get('synonym') as $synonym) {
            $syncArray[(int)$synonym] = ['relationship' => 'synonym'];
          }
        }

        $item->related()->sync($syncArray);
        $syncArray = [];

        if($request->has('antonym')) {
          foreach($request->get('antonym') as $antonym) {
            $syncArray[(int)$antonym] = ['relationship' => 'antonym'];
          }
        }

        $item->related()->sync($syncArray);
        $syncArray = [];

        if($request->has('basic')) {
          foreach($request->get('basic') as $basic) {
            $syncArray[(int)$basic] = ['relationship' => 'basic'];
          }
        }

        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }
}
