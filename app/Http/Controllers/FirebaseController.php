<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;



class FirebaseController extends Controller
{
    public $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(dirname(__DIR__, 3) . env('GOOGLE_APPLICATION_CREDENTIALS'))
            ->withDatabaseUri(env('DATABASE_URI'));

        $this->database = $factory->createDatabase();
    }

    public function index()
    {
        $database = $this->database;

        //$newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
        //$newPost->getUri(env('DATABASE_URI)); //
        //$newPost->getChild('title')->set('Changed post title');
        //$newPost->getValue(); // Fetches the data from the realtime database
        //$newPost->remove();

        // $newPost = $database
        //     ->getReference('blog/posts')
        //     ->push([
        //         'title' => 'Post title',
        //         'body' => 'This should probably be longer.'
        //     ]);


        // $database->getReference('todos')
        //     ->push([
        //         'task' => 'Example Task',
        //         'is_done' => false
        //     ]);


        $data = $database->getReference('Requests')->getvalue();
        $i = 0;
        return $data;
    }

    public function a()
    {
        $database = $this->database;

        $database->getReference('tasks')->push('Hello!');
    }

    public function storeRequest(Request $request)
    {
        $database = $this->database;

        $this->validate($request, [
            'name' => 'required',
            'age' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
            'location' => 'required',
            'description' => 'required'
        ]);

        $name = $request->name;
        $age = $request->age;
        $phone_no = $request->phone_no;
        $email = $request->email;
        $location = $request->location;
        $description = $request->description;
        // $user_id = rand(1000000, 9999999);

        $data = [
            'name' => $name,
            'age' => $age,
            'phone_no' => $phone_no,
            'email' => $email,
            'location' => $location,
            'description' => $description
        ];

        $database->getReference('Requests/')->push($data);

        return redirect()->route('test');
    }

    public function updateRequest(Request $request)
    {
        $database = $this->database;

        $this->validate($request, [
            'name' => 'required',
            'age' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
            'location' => 'required',
            'description' => 'required'
        ]);

        $name = $request->name;
        $age = $request->age;
        $phone_no = $request->phone_no;
        $email = $request->email;
        $location = $request->location;
        $description = $request->description;
        $ref = $request->ref;

        $data = [
            'name' => $name,
            'age' => $age,
            'phone_no' => $phone_no,
            'email' => $email,
            'location' => $location,
            'description' => $description
        ];

        $database->getReference($ref)->update($data);

        return redirect()->route('test');
    }

    public function deleteRequest(Request $request)
    {
        $database = $this->database;
        $id = $request->ref;

        $ref = "Requests/" . $id;
        $database->getReference($ref)->remove();

        return redirect()->route('test');
    }
}
