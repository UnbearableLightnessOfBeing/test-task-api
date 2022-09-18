<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BackpackUpdateUserRequest;
use App\Http\Requests\BackpackCreateUserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Illuminate\Validation\Rule;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('user_name');
        CRUD::column('email');
        CRUD::column('is_blocked')->type('boolean')->label('Blocked')->wrapper([
            'element' => 'span',
            'class'   => static function ($crud, $column, $entry) {
                return 'badge badge-'.($entry->{$column['name']} ? 'danger' : 'success');
            },
        ]);
        $this->crud->removeButton('create');
        $this->crud->removeButton('delete');
        $this->crud->removeButton('show');

        

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $rules = [
            'email' => ['required', 'email', 'unique:App\Models\User'],
            'user_name' => ['required', 'unique:App\Models\User', 'regex:/^[\w\d.-]*$/']
        ];


        CRUD::setValidation($rules);

        CRUD::field('name');
        CRUD::field('user_name');
        CRUD::field('email');
        
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
    
        $userId = $this->crud->getCurrentEntry()['id'];    

        $rules = [
            'user_name' => ['required', 'regex:/^[\w\d.-]*$/', Rule::unique('users', 'user_name')->ignore($userId)]
        ];

        CRUD::setValidation($rules);

        CRUD::field('name');
        CRUD::field('user_name');
        CRUD::field('is_blocked')->label('Block User');
    }
}
