<template>
    <div class="modal fade" id="google-map-popup" tabindex="-1" role="dialog" aria-labelledby="map-popup" aria-hidden="true">
        <div class="modal-dialog window-popup map-popup" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" v-if="university.length>0">{{university.title}}</h6>
                    <div class="more">
                        <svg class="olymp-little-delete js-chat-open"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-little-delete"></use></svg>
                    </div>
                </div>
                <div class="modal-body" v-if="university.length>0">
                    <p>{{university.address}}</p>
                    <google-map :name="name" :markers="markers" v-if="markers.length>0"></google-map>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import GoogleMap from "./GoogleMap";

    export default {
        components: {GoogleMap},
        data: function () {
            return {
                name: 'map',
                university: [],
                markers: [],
            }
        },
        created() {
            Event.listen("GoogleMapPopup", (university) => {
                this.university = university;
                this.markers = [
                    {
                        position: {
                            latitude: this.university.location_lat,
                            longitude: this.university.location_lon
                        }
                    }
                ];
            })
        }
    }
</script>