<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <section
      class="h-full w-full flex flex-col items-center overflow-y-scroll p-5 gap-5"
    >
      <h1 class="text-5xl py-4 font-bold drop-shadow-textShadow2">
        Suas Candidaturas
      </h1>
      <div class="flex gap-4 flex-wrap justify-center"></div>
    </section>

    <Sidebar />
  </main>
</template>

<script>
import Sidebar from "@/components/sidebars/UserSidebar.vue";
import axios from "axios";

export default {
  components: {
    Sidebar,
  },
  data() {
    return {};
  },
  mounted() {},
  methods: {},
};
</script>
