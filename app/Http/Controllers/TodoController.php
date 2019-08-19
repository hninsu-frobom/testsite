<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;


class TodoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function getAllTodo()
    {
        $todo = new Todo();

        $result = $todo->all();

         //return $result;
        return view('alltodo', ['todo'=>$result]);
    }

    public function getTodoById($id)
    {
    	$todo = new Todo();

    	$result = $todo->find($id);

         //return $result;
    	return view('edit', ['todo'=>$result]);
    }

    public function getActiveTodoList()
    {
    //$page=1;
    $todo = new Todo();

    $result = $todo
                ->where('status', '=', 'ACTIVE')
                ->forPage($page, 10)
                ->get();

    //return $result;
     return view('active', ['todos' => $result,'page' => $page]);
     }



    public function getDoneTodoList()
    {
        $page = 1;
    $todo = new Todo();

    $result = $todo
                ->where('status', '=', 'DONE')
                ->forPage($page, 10)
                ->get();

    //return $result;
    // return view('done', ['todos' => $result]);
    return view('done', ['todos' => $result, 'page' => $page]);


    }
    /*
    *
    */
    public function getDeteledTodoList($page)
    {
    $todo = new Todo();

    $result = $todo
                ->where('status', '=', 'DELETED')
                ->forPage($page, 10)
                ->get();

    //return $result;
     return view('deleted', ['todos' => $result]);
    }



    // update
    public function updateTodoById($id, Request $request)
    {
    	//$request['id']=$id;
    	//return $request;
    	$validateData = $request->validate([
    		'todo-title' => 'required|max:100',
    		'todo-description'=> 'required|max:5000',
    		'todo-status' => 'required'
    	]);

    	$todo = Todo::find($id);

    	//set data
    	if(isset($request['todo-title'])){
    		$todo->title = $request['todo-title'];
    	}
    	if (isset($request['todo-description'])) {
    		$todo->description = $request['todo-description'];
    	}
    	if (isset($request['todo-status'])) {
    		$todo->status = $request['todo-status'];
    	}

    	//update
    	$todo->update();

    	return redirect('/todo/all'); // to home page

    }

    // delete 
    public function deleteTodoById($id)
    {
    	//find task with id
    	$todo = Todo::find($id);

    	//delete
    	$todo->delete();
    }


    

}
