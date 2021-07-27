<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class FirebaseController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = app('firebase.database');
    }

    public function index()
    {

        $factory = (new Factory)
            ->withServiceAccount(dirname(__DIR__, 3) . env('GOOGLE_APPLICATION_CREDENTIALS'))
            ->withDatabaseUri(env('DATABASE_URI'));

        $database = $factory->createDatabase();

        $newPost = $database
            ->getReference('blog/posts')
            ->push([
                'title' => 'Post title',
                'body' => 'This should probably be longer.'
            ]);

        //$newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
        //$newPost->getUri(env('DATABASE_URI)); // 
        //$newPost->getChild('title')->set('Changed post title');
        //$newPost->getValue(); // Fetches the data from the realtime database
        //$newPost->remove();

        echo "<pre>";
        print_r($newPost->getvalue());
    }
}
