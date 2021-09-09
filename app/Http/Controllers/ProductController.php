<?php

namespace App\Http\Controllers;

use App\Enums\HTTPCodesEnum;
use App\Http\Requests\ProductRequests\ProductStoreRequest;
use App\Http\Requests\ProductRequests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get this authenticated user
        $user = auth()->user();
        // get Product
        $products = $user->seller->products()->get();
        // check if there is no data found
        if(count($products) == 0){
            return $this->apiResponse(null , HTTPCodesEnum::STATUS_NO_CONTENT , 'There are no Data');
        }
        
        return $this->apiResponse(new ResourceCollection(new ProductResource($products)) , HTTPCodesEnum::STATUS_OK,"Data Retraiv Successfully");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        //get this authenticated user
        $user = auth()->user();
        // check if user is seller or not
        if(!$user->seller()->exists()){ 
           return $this->apiResponse(null, HTTPCodesEnum::STATUS_UNAUTHORIZED , "Unauthorized");
        }
        // get seller model 
        $seller = $user->seller;
        // Create a product and record it in database
        $product = $seller->products()->create($request->all());
        // return successfully response
        return $this->apiResponse(new ProductResource($product) , HTTPCodesEnum::STATUS_CREATED , "Created Successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get this authenticated user
        $user = auth()->user();
        // check if user is seller or not
        if(!$user->seller()->exists()){ 
           return $this->apiResponse(null, HTTPCodesEnum::STATUS_UNAUTHORIZED , "Unauthorized");
        }
        // get Product
        $product = $user->seller->products()->find($id);
        // return successfully response
        return $this->apiResponse(new ProductResource($product) , HTTPCodesEnum::STATUS_OK , "Data Retraiv Successfully");
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        //get this authenticated user
        $user = auth()->user();
        // check if user is seller or not
        if(!$user->seller()->exists()){ 
           return $this->apiResponse(null, HTTPCodesEnum::STATUS_UNAUTHORIZED , "Unauthorized");
        }
        // get Product
        $product = $user->seller->products()->find($id);
        // update product record
        $product->update($request->all());
         // return successfully response
         return $this->apiResponse(new ProductResource($product) , HTTPCodesEnum::STATUS_OK , "Updated Successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get this authenticated user
        $user = auth()->user();
        // check if user is seller or not
        if(!$user->seller()->exists()){ 
           return $this->apiResponse(null, HTTPCodesEnum::STATUS_UNAUTHORIZED , "Unauthorized");
        }
        // get Product
        $product = $user->seller->products()->find($id);
        //check if is not exists
        if(!$product) 
            return $this->apiResponse(null, HTTPCodesEnum::STATUS_NO_CONTENT , "There are no Data");
        //Delete product record
        $product->delete();
        return $this->apiResponse(null, HTTPCodesEnum::STATUS_OK , "Deleted Successfully");
        
    }
}
