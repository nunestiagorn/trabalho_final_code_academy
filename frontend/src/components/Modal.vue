<template>
  <transition name="modal">
    <div
      v-if="visivel"
      class="fixed z-50 top-0 left-0 w-full h-full transition-all bg-black/65"
    >
      <div class="flex items-center justify-center h-full">
        <div
          class="flex flex-col transition-all bg-zinc-200 w-96 rounded-xl p-2 gap-8"
        >
          <div
            class="bg-secondaryColor rounded-md text-zinc-200 font-bold px-4 py-2 text-2xl"
          >
            <slot name="header">Modal Header</slot>
          </div>

          <div class="px-8 text-black">
            <slot name="body">Modal Body</slot>
          </div>

          <div class="">
            <slot name="footer"></slot>
          </div>

          <div class="flex justify-end gap-4 pr-4 pb-2">
            <button
              @click="confirmRedirection"
              class="bg-primaryColor p-1.5 px-2.5 rounded-lg text-lg text-zinc-200 font-semibold"
            >
              OK
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "Modal",
  props: {
    visivel: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
    confirmRedirection() {
      this.$emit("confirm");
    },
  },
};
</script>


<style scoped>
.modal-enter {
  opacity: 0;
}
.modal-leave-active {
  opacity: 0;
}
.modal-enter .modal-container,
.modal-leave-active .modal-container {
  transform: scale(1.1);
}
</style>
