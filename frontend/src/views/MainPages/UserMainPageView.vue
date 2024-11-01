<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <section class="h-full flex flex-col items-center overflow-y-scroll p-5 gap-5">
      <h1 class="text-5xl font-bold">Suas Candidaturas</h1>
      <div class="flex gap-4 flex-wrap justify-center">
        <div class="UserCard border-b-8 border-yellow-600">
          <h3 class="font-bold text-xl">Vaga</h3>
          <h4 class="font-medium text-md self-start text-gray-600" >Empresa tal</h4>
        </div>
        <div class="UserCard border-b-8 border-yellow-600">
          <h3 class="font-bold text-xl">Vaga</h3>
          <h4 class="font-medium text-md self-start text-gray-600" >Empresa tal</h4>
        </div>
        <div class="UserCard border-b-8 border-yellow-600">
          <h3 class="font-bold text-xl">Vaga</h3>
          <h4 class="font-medium text-md self-start text-gray-600" >Empresa tal</h4>
        </div>
        <div class="UserCard border-b-8 border-yellow-600">
          <h3 class="font-bold text-xl">Vaga</h3>
          <h4 class="font-medium text-md self-start text-gray-600" >Empresa tal</h4>
        </div>
        <div class="UserCard border-b-8 border-yellow-600">
          <h3 class="font-bold text-xl">Vaga</h3>
          <h4 class="font-medium text-md self-start text-gray-600" >Empresa tal</h4>
        </div>
        <div class="UserCard border-b-8 border-yellow-600">
          <h3 class="font-bold text-xl">Vaga</h3>
          <h4 class="font-medium text-md self-start text-gray-600" >Empresa tal</h4>
        </div>
      </div>
    </section>

    <Sidebar />
  </main>
</template>

<script>
import Sidebar from "@/components/UserSidebar.vue";

export default {
  components: {
    Sidebar,
  },
};
</script>
