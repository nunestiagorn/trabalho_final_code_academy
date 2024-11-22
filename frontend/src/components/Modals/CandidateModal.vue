<template>
  <transition name="modalCandidate">
    <div
      v-if="visivel"
      class="fixed z-50 top-0 left-0 w-full h-full transition-all bg-black/75"
    >
      <div class="flex items-center justify-center h-full">
        <div
          class="flex flex-col transition-all bg-zinc-200 w-5/12 rounded-xl p-2 gap-8"
        >
          <div class="bg-secondaryColor p-2 rounded-lg text-2xl font-bold">
            <slot name="headerCandidate">Modal Header</slot>
          </div>

          <div class="px-10 text-black text-xl font-medium">
            <slot name="bodyCandidate">Modal Body</slot>
          </div>

          <div class="flex justify-end gap-4 pr-4 pb-2">
            <button
              @click="closeModal"
              class="bg-primaryColor p-1.5 px-2.5 rounded-lg shadow-lg text-lg text-zinc-200 font-semibold hover:bg-darkBlue transition-all"
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
  name: "modalCandidate",
  props: {
    visivel: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
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
