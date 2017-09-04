<template>
	<div class="content">
    	<pick-modal @close="choosePlayer = false" v-if="choosePlayer"></pick-modal>
        <div class="container main-page-container">
	        <div class="row">
		        <div class="col-md-4">
	        		<h2 class="current-player">Current Player On Auction</h2>
	        		<div class="high-bid">
	        			<table class="table table-bordered">
	        				<thead>
	        					<tr><th>Current High Bid:</th><th>Amount:</th></tr>
	        				</thead>
	        				<tbody>
		        				<tr>
		        					<td><span v-if="highBidder">{{highBidder.team_name}}</span></td>
		        					<td>$ {{highBidAmount}}</td>
		        				</tr>
	        				</tbody>
	        			</table>
	        			
	        		</div>
	        		<div class="player-on-auction-container">
	        			Time Left: {{ timer }}
	        			<div class="the-player" v-if="currentPlayer">
	        				<table class="table table-bordered">
	        					<thead>
	        						<tr><th>Name</th><th>Position</th><th>Team</th></tr>
	        					</thead>
	        					<tbody>
	        						<tr>
	        							<td>{{currentPlayer.name}}</td>
	        							<td>{{currentPlayer.position}}</td>
	        							<td>{{currentPlayer.team}}</td>
	        						</tr>
	        					</tbody>
	        				</table>
	        			</div>
	        		</div>
	        		<div v-if="showBidForm" class="bid-on-player">
	        			<form @submit.prevent="saveBid">
		        			<input placeholder="Bid Amount" class="form-control" type="number" name="bid" v-model="bid">
		        			<button class="btn btn-primary">Submit</button>
		        		</form>
	        		</div>
	        		<div class="max-bid"><strong>Your Max Bid:</strong> {{maxBid}}</div>
	        	</div>
	        	<div class="col-md-4">
		        	<current-teams :teams="currentTeams"></current-teams>
		        </div>
		        <div class="col-md-4">
	        		<wall :user="user"></wall>
	        	</div>
	        </div>
        </div>
    </div>
</template>

 <script>
 	Vue.component('wall', require('./Wall.vue'));
	Vue.component('current-teams', require('./CurrentTeams.vue'));
	Vue.component('pick-modal', require('./PickModal.vue'));

	var moment = require('moment');
	
	export default {

		data: function() {
			return {
				interval: null,
				now: new Date(),
				date: moment().add(60, 'seconds').toDate(),
				choosePlayer: false,
				currentPlayer: null,
				highBidder: null,
				highBidAmount: null,
				bid: null,
				showBidForm: false,
				maxBid: this.currentMaxBid,
				currentTeams: this.teams
			}
		},

	 	methods: {
	 		countdown(now, then) {
		      	if(0 < then - now) {
		      		return moment.utc(then - now).format('HH:mm:ss');
		      	}
		      	this.showBidForm = false;
		      	this.startTimer(2);

				axios.post('/auction_winner', {
		            id: this.highBidder.id,
		            amount: this.highBidAmount,
		            player: this.currentPlayer
		          })
		          .then(function (response) {
		            console.log(response);
		          })
		          .catch(function (error) {
		            console.log(error);
		          });
		        return;
		    },

		    startTimer(onOff) {
		    	if(onOff===2) {
		    		clearInterval(this.interval)
		    		return;
		    	}
		    	this.date = moment().add(100, 'seconds').toDate();
		    	this.interval = setInterval(() => {
			       this.now = new Date()
			    }, 1000)
		    },

		    saveBid() {
		    	if(this.bid > this.maxBid) {
		    		alert('Your Bid is Higher than Your Max Bid');
		    		return;
		    	}
		    	axios.post('/save_bid', {
		            id: this.user.id,
		            amount: this.bid
		          })
		          .then(function (response) {
		            console.log(response);
		          })
		          .catch(function (error) {
		            console.log(error);
		          });
			}
	  	},

		created () {
	        var channel = this.$pusher.subscribe('pick-channel');
	 
	        channel.bind('new-pick', function(data) {
	            if(data.user == this.user.id) {
	            	this.choosePlayer = true;
	        	}
	        }.bind(this));

	        // To Add player to auction board
	        channel.bind('pick-added-to-auction', function(data) {
	        	this.showBidForm = true;
	        	this.highBidder = data.bidder;
	        	this.highBidAmount = data.amount;
	        	this.currentPlayer = data.player;
	        	this.startTimer(1);
	        }.bind(this));

	        // To Add player to auction board
	        channel.bind('high-bid-added', function(data) {

	        	this.highBidAmount = data.amount;
	        	this.highBidder = data.bidder;
	        }.bind(this));

	        // Refresh Max Bid Amount
            var bidChannel = this.$pusher.subscribe('pick-channel');
            bidChannel.bind('auction-won', function(data) {
                axios.get('/get_max_bid/'+this.user.id)
		          .then(function (response) {
		            this.maxBid = response.data
		          }.bind(this))
            }.bind(this));
        
	    },

	    computed: {
		    timer() {
		    	return this.countdown(this.now, this.date);
		    },
		},

		props: ['user','teams','currentMaxBid']

	}
 </script>

 <style type="text/css">
 	.player-on-auction-container {
	    background: #3097D1;
	    padding: 16px 22px 24px;
	    font-size: 22px;
	    color: #fff;
	}

	.bid-on-player {
		margin-top: 20px;
	}

	.the-player {
		border-top: 1px solid #fff;
		padding-top: 20px;
		margin-top: 20px;
	}
 </style>