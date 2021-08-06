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

        $data = $database->getReference('Requests')->getvalue();
        $i = 0;
        return $data;
    }
    public function indexByUid()
    {
        // $uid = '-MgFNXat5ioqczYm36Sj';
        $uid = $_SESSION['verified_user_id'];
        $database = $this->database;

        $data = $database->getReference('Requests/' . $uid)->getvalue();
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

        $database->getReference('Requests/' . $_SESSION['verified_user_id'])->push($data);

        return redirect()->route('userHome');
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
        $ref = "Requests/" . $_SESSION['verified_user_id'] . '/' . $request->ref;

        $data = [
            'name' => $name,
            'age' => $age,
            'phone_no' => $phone_no,
            'email' => $email,
            'location' => $location,
            'description' => $description
        ];

        $updates = [
            $ref => $data
        ];

        $database->getReference()->update($updates);

        return redirect()->route('userHome');
    }

    public function deleteRequest(Request $request)
    {
        $database = $this->database;
        $id = $request->ref;

        $ref = "Requests/" . $_SESSION['verified_user_id'] . '/' . $id;
        $database->getReference($ref)->remove();

        return redirect()->route('userHome');
    }
}
