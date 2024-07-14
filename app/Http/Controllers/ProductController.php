<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckRole;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
// Begin the declaration of the ProductController class, which extends the base Controller class.
class ProductController extends Controller
{
    // A doc block comment to describe the following method.

    /**
     * Display a listing of the resource.
     */
       
    // The 'index' method is used to get a list of all 'Product' records.
    public function index()
    {
        // Use Laravel's response helper to return a JSON response containing all 'Product' records.
        // The second parameter, 200, is the HTTP status code for OK.
        return response()->json(Product::all(), 200);
    }

    //excel
    public function export()
{
    return Excel::download(new ProductsExport, 'products.xlsx');
    
}

    // Another doc block comment to describe the following method.

    /**
     * Store a newly created resource in storage.
     */
    
    // The 'store' method is used to validate the incoming request and create a new 'Product'.
    public function store(Request $request)
    {
        // Validate the incoming HTTP request with the given rules.
        // 'name' should be present and should not exceed 255 characters.
        // 'description' and 'price' should be present.
        // 'price' should also be a valid numeric value.
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);
    
        // Create a new 'Product' record in the database with the validated data.
        $product = Product::create($validatedData);
    
        // Return the created 'Product' as a JSON response.
        // The second parameter, 201, is the HTTP status code for Created.
        return response()->json($product, 201);
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the product from the database using the provided $id
        $product = Product::find($id);

        // Check if the product was found
        if ($product) {
            // Return the product as a JSON response with a 200 HTTP status code
            return response()->json($product, 200);
        } else {
            // Return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        // Check if the product was found
        if ($product) {
            // Update the product with the validated data
            $product->update($validatedData);
        
            // Return the updated product as a JSON response with a 200 HTTP status code
            return response()->json($product, 200);
        } else {
            // Return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Check if the product was found
        if ($product) {
            // Delete the product
            $product->delete();

            // Return a 204 No Content HTTP status code
            return response()->json(null, 204);
        } else {
            // Return a 404 Not Found HTTP status code if the product was not found
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}  