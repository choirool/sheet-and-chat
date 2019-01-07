<template>
    <div class="container chats">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card card-default">
                    <div class="card-header">Chats</div>

                    <div class="card-body">
                        <chat-messages :messages="messages"></chat-messages>
                    </div>
                    <div class="card-footer">
                        <chat-form
                            @messagesent="addMessage"
                            :user="user"
                        ></chat-form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="list-group" v-if="users">
                    <li class="list-group-item" v-for="user in users" :key="user.id">
                        {{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import ChatForm from './ChatForm.vue'
import ChatMessages from './ChatMessages.vue'

export default {
    props: ['user'],
    components: {
        ChatForm,
        ChatMessages
    },
    created() {
        this.fetchMessages();
        this.joinRoom();
    },
    data() {
        return {
            users: [],
            messages: [],
            typingTimer: false
        }
    },
    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        },

        joinRoom() {
            Echo.join('chat')
                .here(users => {
                    this.users = users;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id !== user.id);
                })
                .listenForWhisper('typing', ({id, name}) => {
                    this.users.forEach((user, index) => {
                        if (user.id === id) {
                            user.typing = true;
                            this.$set(this.users, index, user);

                            if(this.typingTimer) {
                                clearTimeout(this.typingTimer);
                            }

                            this.typingTimer = setTimeout(() => {
                                user.typing = false;
                                this.$set(this.users, index, user);
                            }, 3000);
                        }
                    });
                })
                .listen('MessageSent', (event) => {
                    this.messages.push({
                        message: event.message.message,
                        user: event.user
                    });

                    this.users.forEach((user, index) => {
                        if (user.id === event.user.id) {
                            user.typing = false;
                            this.$set(this.users, index, user);
                        }
                    });
                });
        }
    }
}
</script>

<style>

</style>


