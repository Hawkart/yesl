<template>
    <a href="#"  data-toggle="modal" data-target="#google-map-popup" class="pin-google" @click.prevent="setMaps">
        <i class="fas fa-map-marker-alt"></i>
    </a>
</template>


<script>
    export default {
        props: ['university'],

        methods: {
            setMaps() {
                Event.fire("GoogleMapPopup", this.university);
            }
        }
    }
</script>