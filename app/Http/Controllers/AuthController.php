<?php

// Include necessary namespaces
namespace App\Http\Controllers;

use Illuminate\Http\Request; // For handling HTTP requests
use Illuminate\Support\Facades\Auth; // For handling authentication
use App\Models\User; // User model
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\users;

// Define AuthController class which extends Controller
class AuthController extends Controller
{
    //chart function
    public function adminindex()
    {
       $data=users::select('id','created_at')->get()->groupBy(function($data){
        return Carbon::parse($data->created_at)->format('M');

       });
       return view('adminindex',['data'=>$data]);
    }
    
    
    
    // Function to handle user registration

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer', // Assign 'customer' role by default
        ]);
    
        return response()->json(['user' => $user], 201);
    }

    public function listUsers()
{
    // Fetch all users
    $users = User::all();

    // Pass the users data to the view and return the view
    return View::make('users.index', ['users' => $users]);
}
    

    // Function to handle user login
    public function login(Request $request)
    {
        // Validate incoming request fields
        $request->validate([
            'email' => 'required|string|email', // Email must be a string, a valid email and it is required
            'password' => 'required|string', // Password must be a string and it is required
        ]);

        // Check if the provided credentials are valid
        if (!Auth::attempt($request->only('email', 'password'))) {
            // If not, return error message with a 401 (Unauthorized) HTTP status code
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        // If credentials are valid, get the authenticated user
        $user = $request->user();
        // Create a new token for this user
        $token = $user->createToken('authToken')->plainTextToken;

        // Return user data and token as JSON
        return response()->json(['user' => $user, 'token' => $token]);
    }

    // Function to handle user logout
    public function logout(Request $request)
    {
        // Delete all tokens for the authenticated user
        $request->user()->tokens()->delete();

        // Return success message as JSON
        return response()->json(['message' => 'Logged out']);
    }
}
