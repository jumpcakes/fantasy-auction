<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;
use Pusher;
use Auth;
use App\Auction;
use App\User;

class PlayersController extends Controller
{
    public function index(Request $request) {

    	$query = Player::where('taken',0);

        if ($request->exists('position')) {
            if($request->position != 1) {
                $query->where('position',$request->position);
            }   
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('name', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;

        $pagination = $query->paginate($perPage);

        return response()->json(
                $pagination
            )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function pickPlayer(Request $request)
    {
    	$player = Player::where('id',$request->id)->firstOrFail();
    	$player->update(['taken'=>0]);

    	Auction::create(['user_id'=>Auth::user()->id,'player_id'=>$player->id,'high_bid'=>1,'draft_position'=>Auth::user()->draftOrder->id]);

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

		$data['player'] = $player;
		$data['bidder'] = Auth::user();
		$data['amount'] = 1;
		$pusher->trigger('pick-channel', 'pick-added-to-auction', $data);
		return 'ready';
    }

    public function bidOnPlayer(Request $request)
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

		$data['amount'] = $request->amount;
		$data['bidder'] = Auth::user();
		$pusher->trigger('pick-channel', 'high-bid-added', $data);
		return $request->all();
    }

    public function auctionWinner(Request $request) 
    {
     //    $user = User::where('id',$request->id)->first();
     //    $player = Player::where('id',$request->player['id'])->first();
     //    if($user->players()->where('player_id',$player->id)->count() ===0) {
     //        $user->players()->attach($player->id);
     //        $userMoney = ($user->money - $request->amount);
     //        $player->update(['salary'=>$request->amount,'taken'=>1]);
     //        $user->update(['money'=>$userMoney]);
     //    }

     //    $options = array(
     //        'cluster' => 'us2',
     //        'encrypted' => true
     //    );

     //    $pusher = new Pusher\Pusher(
     //        '13d6291867576b0aa8ac',
     //        '77251cbefd5458cbe35a',
     //        '392790',
     //        $options
     //    );

     //    $users = User::all();
     //    $users->load('players');

     //    $data['teams'] = $users;
     //    $data['maxBid'] = Auth::user()->getMaxBid();
     //    $pusher->trigger('pick-channel', 'auction-won', $data);

    	// return $request->all();
    }

    public function maxBid(User $user) 
    {
        return $user->getMaxBid();
    }
}
