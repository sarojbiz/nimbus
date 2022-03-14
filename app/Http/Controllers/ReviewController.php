<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Validator;
use App\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(REQUEST $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = array('response' => 'failure', 'message' => 'error');
		if( $request->ajax() ) {
			$input = $request->all();
			$rules=[
                'review_name' => 'required',
                'review_rating' => 'required',
                'review_email' => 'required|email',
                'product_review' => 'required'
			];
			$messages=[
                'review_name.required' => 'Your name is required for product review.',
                'review_rating.required' => 'Your rating is required for product review.',
                'review_email.required' => 'Your email is required for product review.',
                'product_review.required' => 'Review is required for product review.'
			];
			$validate=validator::make($input, $rules, $messages);
			if($validate->fails())
			{
				$response = array('response' => 'failure', 'message' => 'Please entry all required fields for product review.');
			}
			else
			{
                $mcode = Crypt::decryptString($request->product_id);
				try{
                    $review = new Review();
                    $review->mcode = $mcode;
                    $review->review_name = $request->review_name;
                    $review->review_email = $request->review_email;
                    $review->review_rating = $request->review_rating;
                    $review->review = $request->product_review;
					$review->save();
					$response = array('response' => 'success', 'message' => 'Thank You for your review.');
				}
				catch(Exception $e){
					$response = array('response' => 'failure', 'message' => 'Please entry all required fields for product review.');
				}
			}
		}		
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
