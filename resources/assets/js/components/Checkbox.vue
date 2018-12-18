<template>
  <div class="checkbox">
    <label>
      <input :name="name"
             :checked="internalValue"
             :id="id || name"
             type="checkbox"
             @click="handleClick">
      <slot/>
    </label>
  </div>
</template>

<script>
export default {
  name: 'Checkbox',

  props: {
    id: { type: String, default: null },
    name: { type: String, default: 'checkbox' },
    value: { type: Boolean, default: false },
    checked: { type: Boolean, default: false }
  },

  data: () => ({
    internalValue: false
  }),

  watch: {
    value (val) {
      this.internalValue = val
    },

    checked (val) {
      this.internalValue = val
    },

    internalValue (val, oldVal) {
      if (val !== oldVal) {
        this.$emit('input', val)
      }
    }
  },

  created () {
    this.internalValue = this.value

    if ('checked' in this.$options.propsData) {
      this.internalValue = this.checked
    }
  },

  methods: {
    handleClick (e) {
      this.$emit('click', e)

      if (!e.isPropagationStopped) {
        this.internalValue = e.target.checked
      }
    }
  }
}
</script>
<style>
  .checkbox.is-invalid{
    color: #dc3545;
  }
</style>
