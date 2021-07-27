<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
// use Dotenv\Dotenv;

// require __DIR__ . '/../../../vendor/autoload.php';

// $dotenv = Dotenv::createImmutable(dirname(__DIR__, 3));
// $dotenv->load();

// $firebase_credentials = $_ENV['FIREBASE_CREDENTIALS'];
// $databaseUri = $_ENV['DATABASE_URI'];
// $credentials_dir = __DIR__ . '\\' . $firebase_credentials;


class FirebaseController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = app('firebase.database');
    }

    public function index()
    {
        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/usforus-3e70b-firebase-adminsdk-gk8cq-2ef7bec42a.json');
        // $firebase = (new Factory)
        //     ->withServiceAccount($serviceAccount)
        //     ->withDatabaseUri('https://laraveltesting-bd2b9.firebaseio.com/')
        //     ->create();
        // $database = $firebase->getDatabase();

        $factory = (new Factory)
            ->withServiceAccount(__DIR__ . env('GOOGLE_APPLICATION_CREDENTIALS'))
            ->withDatabaseUri(env('DATABASE_URI'));

        // $factory = (new Factory)
        // ->withServiceAccount(__DIR__ . '/usforus-3e70b-firebase-adminsdk-gk8cq-2ef7bec42a.json')
        // ->withDatabaseUri('https://usforus-3e70b-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $database = $factory->createDatabase();

        $newPost = $database
            ->getReference('blog/posts')
            ->push([
                'title' => 'Post title',
                'body' => 'This should probably be longer.'
            ]);

        //$newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
        //$newPost->getUri(env('DATABASE_URI)); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-
        //$newPost->getChild('title')->set('Changed post title');
        //$newPost->getValue(); // Fetches the data from the realtime database
        //$newPost->remove();

        echo "<pre>";
        print_r($newPost->getvalue());
    }
}
