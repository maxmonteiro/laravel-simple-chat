<template>
    <div>
        <h2>Laravel Chat</h2>
        <p v-for="message in messages" :key="message.id">{{ message }}</p>
        <input type="text" v-model="text">
        <button @click="postMessage" :disabled="!contentExists">Submit</button>
    </div>
</template>
<script>
export default {
    data() {
        return {
            text: '',
            messages: []
        }
    },
    created() {
        this.getMessages();

        // Registered client on public channel to listen to MessageSent event
        Echo.channel('public').listen('MessageSent', ({message}) => {
            this.messages.push(message);
        })
    },
    computed: {
        contentExists() {
            return this.text.length > 0;
        }
    },
    methods: {
        getMessages() {
            axios.get('/getAll')
            .then(({data}) => {
                this.messages = data;
            }).catch((err) => {

            });
        },
        postMessage() {
            let message = { message: this.text };
            axios.post('/post', message)
            .then(({data}) => {
                this.messages.push(data);
                this.text = '';
            }).catch((err) => {

            });
        }
    }
}
</script>
