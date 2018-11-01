<template>
    <div class="google-map" :id="name"></div>
</template>

<script>
    export default {
        name: 'google-map',
        props: ['name', 'markers'],
        data: function () {
            return {
                map: '',
                /*markers: [
                    {
                        position: {
                            latitude: 59.93,
                            longitude: 30.32
                        }
                    },
                    {
                        position: {
                            latitude: 59.928,
                            longitude: 30.32
                        }
                    }
                ]*/
            }
        },
        computed: {
            mapMarkers: function () {
                return this.markers
            }
        },
        mounted: function () {
            /*eslint-disable */
            const element = document.getElementById(this.name)
            const options = {
                zoom: 14,
                center: new google.maps.LatLng(this.markers[0].position.latitude, this.markers[0].position.longitude)
            }
            this.map = new google.maps.Map(element, options)

            this.markers.forEach((marker) => {
                const position = new google.maps.LatLng(marker.position.latitude, marker.position.longitude)
                marker.map = this.map
                marker.position = position
                new google.maps.Marker(marker)
            })
            /*eslint-enable */
        },
        methods: {

        }
    }
</script>

<style scoped>
    .google-map {
        width: 640px;
        height: 480px;
        margin: 0 auto;
        background: gray;
    }
</style>