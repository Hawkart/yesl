<template>
    <a href="#"  data-toggle="modal" data-target="#chat-dialog-form" class="btn btn-control bg-purple"
       @click.prevent="setPrivateParticipant">
        <svg class="olymp-chat---messages-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-chat---messages-icon"></use></svg>
    </a>
</template>


<script>
    export default {
        props: ['participant'],

        methods: {
            setPrivateParticipant() {
                Event.fire("PrivateDialogMessage", this.participant);
            }
        }
    }
</script>