<template>
    <a href="#"  data-toggle="modal" data-target="#chat-dialog-form" class="btn" v-bind:class="classes" @click.prevent="setPrivateParticipant">
        <slot></slot>
    </a>
</template>


<script>
    export default {
        props: ['participant', 'classes'],

        methods: {
            setPrivateParticipant() {
                Event.fire("PrivateDialogMessage", this.participant);
            }
        }
    }
</script>