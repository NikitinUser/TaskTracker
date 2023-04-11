<template>
<div class="modal-mask" tabindex="-1">
    <div class="modal-wrapper">
        <div class="spinner-border text-warning" role="status"></div>
    </div>
</div>   
</template>

<script>
export default {
    name: 'LoadingSpinner',
}
</script>

<style scoped>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
    padding-top: 100px;
}
.modal-wrapper {
  display: flex;
  align-items: center;
  justify-content: center
}
</style>
