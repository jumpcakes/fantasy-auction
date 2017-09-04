<template>
    <div>
        <div class="team-title">{{team.team_name}} - <small>({{team.name}})</small> <span style="float:right;">${{team.money}}</span></div>
        <h4>Roster - <small><a style="color:#fff;" @click.prevent="showRoster" href="#">({{toggleText}})</a></small></h4>
        <table v-if="roster" class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Team</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="player in team.players">
                    <td>{{player.name}}</td>
                    <td>{{player.position}}</td>
                    <td>${{player.salary}}.00</td>
                    <td>{{player.team}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        created () {
            var channel = this.$pusher.subscribe('my-channel');
     
            channel.bind('my-event', function(data) {
                this.message = data.message;
            }.bind(this));
        },

        data: function() {
            return {
                roster: false,
                toggleText: 'show'
            }
        },

        methods: {
            showRoster() {
                this.roster = !this.roster;
                if(this.roster == true) {
                    this.toggleText = 'hide';
                    return 
                }
                this.toggleText = 'show';
                return
            }
        },

        props: ['team']
    }
</script>

<style type="text/css">
    .team-list li {
        list-style-type: none;
        background: #566d6f;
        margin-bottom: 4px;
        padding: 11px;
        color: #fff;
    }

    .team-title {
        border-bottom: 1px solid;
    }

    .team-list  {
        padding-left: 0;
    }
</style>
