<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher;
use App\Auction;
use App\DraftOrder;
use App\Draft;


class PagesController extends Controller
{
    public function pushMessage(Request $request)
    {
    	$options = array(
		    'cluster' => 'us2',
		    'encrypted' => true
		);

		$pusher = new Pusher\Pusher(
		    '13d6291867576b0aa8ac',
		    '77251cbefd5458cbe35a',
		    '392790',
		    $options
		);

		$data['message'] = $request->message;
		$pusher->trigger('my-channel', 'my-event', $data);
		return 'pushed';
    }
    

    public function promptPick() {
    	$draft = Draft::find(1);
    	$first_match_check = Auction::all();
    	if($first_match_check->count() < 1) {
    		$next_pick = 1;
    	} else {
    		$next_pick = Auction::orderBy('id', 'desc')->first()->draft_position +1;
    	}
    	
    	if($next_pick > $draft->number_teams) {
    		$next_pick = 1;
    	} 

    	$drafter = DraftOrder::find($next_pick);
    	
    	$options = array(
		    'cluster' => 'us2',
		    'encrypted' => true
		);

		$pusher = new Pusher\Pusher(
		    '13d6291867576b0aa8ac',
		    '77251cbefd5458cbe35a',
		    '392790',
		    $options
		);

		$data['user'] = $drafter->user_id;
		$pusher->trigger('pick-channel', 'new-pick', $data);
		return 'ready';
    }
}
