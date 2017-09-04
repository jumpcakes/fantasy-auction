<template>
    <div class="wall">
        <div class="message-container">
            <h2 style="margin-top:0;">Messages</h2>
            <div class="wall-message-title">Welcome to The Skol Fantasy Draft</div>
            <table class="table table-striped">
                <tbody>
                    <tr class="wall-message" v-for="message in theMessages">
                        <td>
                            <strong>{{message.user}}</strong> - {{message.note}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <form @submit.prevent="saveMessage">
                <input class="form-control message-input" type="text" name="message" v-model="chatMessage">
                <button class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        created () {
            var channel = this.$pusher.subscribe('my-channel');
     
            channel.bind('my-event', function(data) {
                this.messages.push({note: data.message, user: this.user.team_name});
            }.bind(this));
        },

        data: function() {
            return {
                messages: [],
                chatMessage: null
            }
        },

        computed: {
            theMessages() {
                return this.messages.reverse();
            }
        },

        methods: {
            saveMessage() {

                axios.post('/push', {
                    message: this.chatMessage,
                  })
                  .then(function (response) {
                    console.log(response);
                  })
                  .catch(function (error) {
                    console.log(error);
                  });

            }
        },

        props: ['user']
    }
</script>

<style type="text/css">
    .wall-message-title {
        border-bottom: 1px solid;
        padding: 10px;
    }
</style>
