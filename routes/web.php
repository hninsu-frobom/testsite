<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Todo;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**
 * Get the All todo tasks for a given page.
 */
Route::get('/todo/all/{page?}', function($page = 1) {
    // code to fetch the todo tasks on page = $page
      // return view('home');
    $todo = new Todo();

     $result = $todo
                ->get();

      return view('alltodo', ['todos' => $result, 'page' => $page]);
});


/**
 * Get the ACTIVE todo tasks for a given page.
 */
Route::get('/todo/active/{page?}', function($page = 1) {
    // code to fetch the todo tasks on page = $page
     

     $todo = new Todo();

     $result = $todo
                ->where('status', '=', 'ACTIVE')
                ->forPage($page, 10)
                ->get();
    return view('active', ['todos' => $result, 'page' => $page]);
});

//Route::get('/todo/active/{page?}','TodoController@getActiveTodoList');
/**
 * Get the DONE todo tasks for a given page.
 */
Route::get('/todo/done/', 'TodoController@getDoneTodoList');

/**
 * Get the DELETED todo tasks for a given page.
 */
Route::get('/todo/deleted/{page}', 'TodoController@getDeteledTodoList');

/**
 * Get a specific todo task by id.
 */
Route::get('/todo/{id}', 'TodoController@getTodoById');
    // code to fetch todo task having id = $id


/**
 * Create a new todo task.
 */
Route::post('/todo', function(Request $request) {

    // validate
    $validator = Validator::make($request->all(), [
        'todo-title' => 'required|max:100',
        'todo-description' => 'required|max:5000',
    ]);

    // if error
    if ($validator->fails()) {
        return 'Error in submitted data.';
    }

    // now create new todo
    $todo = new Todo();

    if (isset($request['todo-title'])) {
        $todo->title = $request['todo-title'];
    }
    if (isset($request['todo-description'])) {
        $todo->description = $request['todo-description'];
    }

    // now save
    $todo->save();

    // redirect to list
    return redirect('/todo/all');

});
/**
 * Update / Edit a specific todo task by id.
 */
Route::put('/todo/{id}', 'TodoController@updateTodoById');

/**
 * Delete a specific todo task by id.
 */
Route::delete('/todo/{id}', 'TodoController@deleteTodoById');
    // code to delete todo task having id = $id

Route::get('image-upload', 'ImageUploadController@imageUpload')->name('image.upload');

Route::post('image-upload', 'ImageUploadController@imageUploadPost')->name('image.upload.post');