<template>
    <button :type="nativeType" :disabled="loading" :class="{
    [`btn-${type}`]: true,
    'btn-block': block,
    'btn-lg': large,
    'btn-loading': loading,
    [`${additional}`]: true
  }" class="btn">
        <span v-if="loading">Loading...</span>
        <slot v-else/>
    </button>
</template>

<script>
    export default {
        name: 'VButton',

        props: {
            type: {
                type: String,
                default: 'primary'
            },

            additional: {
                type: String,
                default: ''
            },

            nativeType: {
                type: String,
                default: 'submit'
            },

            loading: {
                type: Boolean,
                default: false
            },

            block: {
                type: Boolean,
                default: false
            },

            large: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
