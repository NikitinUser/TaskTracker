<template>
<div class="modal-mask" tabindex="-1">
    <div class="modal-wrapper text-white">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Загрузка</h5>
        </div>
        <div class="modal-body">
            <center>
                <div class="spinner-border text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </center>
        </div>
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
}
.modal-wrapper {
  display: flex;
  align-items: center;
  justify-content: center
}
</style>
