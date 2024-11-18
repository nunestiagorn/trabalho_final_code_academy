<template>
  <transition name="ModalJobDetail">
    <div
      v-if="visivel"
      class="fixed z-50 top-0 left-0 w-full h-full transition-all bg-black/75"
    >
      <div class="flex items-center justify-center h-full">
        <div
          class="flex flex-col transition-all bg-zinc-200 w-5/12 p-2 rounded-xl"
        >
          <div class="flex flex-col gap-6 pb-1">
            <div class="bg-secondaryColor p-2 rounded-lg text-2xl font-bold">
              <slot name="headerJobDetail">Modal Header</slot>
            </div>

            <div class="px-7 text-black text-xl font-medium">
              <slot name="bodyJobDetail">Modal Body</slot>
            </div>

            <div class="px-3 text-black text-xl font-medium flex justify-end gap-3">
              <slot name="buttonsJobDetail">
                botões
              </slot>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "ModalJobDetail",
  props: {
    visivel: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
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
