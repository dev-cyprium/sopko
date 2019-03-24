<template>
  <div class="parent-overlay" @click="onClick">
      <div :class="selected ? 'overlay':''" />
      <slot />
  </div>
</template>

<style>
    .parent-overlay {
        position: relative;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #4caf50;
        z-index: 1;
        opacity: 0.5;
    }
</style>


<script>
export default {
    data() {
        return {
            selected: false
        }
    },
    methods: {
        onClick() {
            this.selected = !this.selected
            this.$emit('click', this.selected)
        }
    }
}
</script>
