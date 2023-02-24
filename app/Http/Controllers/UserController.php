<?php

namespace App\Http\Controllers;

//use App\Services\ApiService;
use App\Models\User;
use App\Repositories\MongoRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

//    protected $apiService;
//    /**
//     * Dependency Injection
//     */
//    public function __construct(ApiService $apiService)
//    {
//        $this->apiService = $apiService;
//    }

    /***
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
//        $dsn = env('MONGO_DB_DSN');
//        dd($dsn);exit;
        $request->validate(['username' => 'required', 'email' => 'required', 'password' => 'required']);
        $result = ["return_code" => '0000'];
//        print_r($request->all());exit;
        User::create($request->all());
        return response()->json($result);
    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        request()->validate([
//            'name' => 'required',
//            'detail' => 'required',
//        ]);
//
//
//        Book::create($request->all());
//
//
//        return redirect()->route('books.index')
//            ->with('success','Book created successfully.');
//    }

    public function findUser(Request $request)
    {
        $id = $request->input('id');
        $users = User::find($id);
        return response()->json($users);
    }
}
