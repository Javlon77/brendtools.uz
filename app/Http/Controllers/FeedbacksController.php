<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbacksController extends Controller
{
    // waiting for 7 days to enable manager to call client
    public function pending()
    {
        $interval = now()->subDay(7)->format('Y-m-d');
        $feedbacks = Feedback::whereDate('sale_date', '>', $interval)->with(['client', 'sale'])->get();
        return view('feedbacks.pending', compact('feedbacks') );
    }
    // after 7 days appeared the editable form 
    public function ask()
    {
        $interval = now()->subDay(7)->format('Y-m-d');
        $feedbacks = Feedback::whereDate('sale_date', '<=', $interval)->where('asked', '=', 0)->orderBy('sale_date', 'asc')->with(['client', 'sale'])->get();
        return view( 'feedbacks.ask', compact('feedbacks') );
    }
    // if manager talked with customer
    public function asked()
    {
        $feedbacks = Feedback::where('reviewed', '=', 0)->where('will_review', '=', 1)->where('asked', '=', 1)->with(['client', 'sale'])->orderBy('sale_date', 'desc')->get();
        return view( 'feedbacks.asked', compact('feedbacks') );
    }
    // if customer reviewed on website
    public function reviewed()
    {
        $feedbacks = Feedback::where('reviewed', '=', 1)->with(['client', 'sale'])->get();
        return view( 'feedbacks.reviewed', compact('feedbacks') );
    }
    // customer doesn't want to leave review
    public function willNotReview()
    {
        $feedbacks = Feedback::where('will_review', '=', 0)->with(['client', 'sale'])->get();
        return view( 'feedbacks.willNotReview', compact('feedbacks') );
    }
    // edit form
    public function edit($id)
    {
        $feedback = Feedback::find($id);
        return view( 'feedbacks.edit', compact('feedback') );
    }
    // update form
    public function update(Request $request, $id)
    {
        $feedback                       = Feedback::find($id);
        $feedback['asked']              = 1;
        $feedback['rank']               = $request ->rank;
        $feedback['comment']            = $request ->comment;
        $feedback['reviewed']           = $request ->reviewed;
        $feedback['reviewed_by_client'] = $request ->reviewed_by_client !== NULL ? $request ->reviewed_by_client : 1 ;
        $feedback-> save();
        return redirect($request->session() -> get('previous'));
    }
    // to set client as will not review
    public function SetAsWillNotReview($id)
    {
        $feedback                   = Feedback::find($id);
        $feedback['will_review']    = 0;
        $result                     = $feedback ->save();
        
        return back();
    }
    // to backt from set-as-will-not-review
    public function back($id)
    {
        $feedback                   = Feedback::find($id);
        $feedback['will_review']    = 1;
        $result                     = $feedback ->save();

        return back();
    }
}
