<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <Sidebar />

    <section
      class="h-full w-full flex flex-col items-center overflow-y-scroll p-5 gap-5"
    >
      <h1 class="text-5xl font-bold drop-shadow-textShadow2">Suas Vagas Publicadas</h1>
      <div class="flex gap-4 flex-wrap justify-center">

      </div>
    </section>
  </main>
</template>

<script>
import Sidebar from "@/components/sidebars/CompanySidebar.vue";

export default {
  components: {
    Sidebar,
  },
};
</script>
