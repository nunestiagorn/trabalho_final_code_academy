<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <RouterLink
      :to="prevRoute || '/:id/mainpage'"
      class="absolute top-4 left-4 text-lg px-4 py-2.5 font-semibold hover:text-zinc-300 bg-darkBlue rounded-[100px] hover:bg-darkerBlue transition-all duration-150 shadow-xl hover:rounded-xl"
    >
      <ArrowLeft />
      Voltar
    </RouterLink>

    <section
      class="h-full w-full flex flex-col items-center overflow-y-scroll px-6 py-10 gap-5"
    >
      <h1 class="text-5xl font-bold drop-shadow-textShadow2">
        Empresas Conveniadas no nosso site
      </h1>
      <div
        class="flex gap-3 items-center text-5xl font-bold drop-shadow-textShadow2"
      >
        <h2>Pampa's</h2>
        <img
          src="../../assets/images/logo.png"
          alt="logo do site"
          class="w-28"
        />
        <h2>RH</h2>
      </div>
      <div
        class="bg-zinc-200 w-full max-h-80 rounded-xl overflow-y-scroll shadow-xl p-6 space-y-4"
      >
        <h1 class="text-center text-black text-2xl font-semibold">Lista de Empresas Cadastradas na Pampa's RH</h1>
        <div
          v-for="company in companies"
          :key="company.id"
          class="flex justify-between items-center p-3 border-b border-gray-700 text-black"
        >
          <div class="flex flex-col">
            <h2 class="font-semibold text-xl">Nome: {{ company.name }}</h2>
            <h3 class="text-lg text-gray-800">CNPJ: {{ company.cnpj }}</h3>
          </div>
          <div class="text-sm font-medium max-w-64 min-w-64 max-h-48 overflow-y-scroll bg-neutral-300 p-2 rounded-md">
            {{ company.description }}
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import axios from "axios";

export default {
  components: {},
  data() {
    return {
      companies: [],
      prevRoute: null,
    };
  },
  methods: {
    getCompanies() {
      axios.get(`http://localhost:8001/api/companies/`).then(({ data }) => {
        this.companies = data;
      });
    },
  },
  mounted() {
    this.getCompanies();
  },
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      vm.prevRoute = from.path;
    });
  },
};
</script>
