<template>
    <div class="current-teams">
        <h2 style="margin-top:0px">Current Teams</h2>
        <ul class="team-list">
            <li v-for="team in currentTeams">
                <team :team="team"></team>
            </li>
        </ul>
    </div>
</template>

<script>
    Vue.component('team', require('./Team.vue'));

    export default {
        created () {
            var channel = this.$pusher.subscribe('pick-channel');

            // Refresh teams list after pick added
            channel.bind('auction-won', function(data) {
                this.currentTeams = data.teams
            }.bind(this));
        },

        data: function() {
            return {
                currentTeams: this.teams
            }
        },

        props: ['teams']
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
