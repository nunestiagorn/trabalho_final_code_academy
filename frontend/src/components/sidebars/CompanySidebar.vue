<template>
  <aside class="bg-neutral-200 flex flex-col w-3/12 items-center gap-4 p-3">
    <div class="flex flex-col pt-4">
      <div class="flex flex-col gap-3 items-center">
        <h3 class="text-zinc-600 text-md -mt-1">CNPJ: {{ company.cnpj }}</h3>
        <img
          src="@/assets/images/company.png"
          alt="foto da empresa"
          class="size-16 rounded-full"
        />
        <div class="flex flex-col text-black capitalize items-center">
          <h2 class="font-bold text-xl">
            {{ company.name }}
          </h2>
          <h2 class="text-lg">Recrutador: Moaca</h2>
        </div>
      </div>
    </div>

    <hr class="border-px border-zinc-500 w-11/12" />

    <section
      class="flex flex-col justify-between h-full w-full px-4 font-semibold text-zinc-200 text-lg"
    >
      <div class="flex flex-col gap-5">
        <RouterLink to="/editar_perfil" class="company_sidebar_item">
          <UserCog />
          Editar Recrutador
        </RouterLink>

        <RouterLink to="/editar_perfil" class="company_sidebar_item">
          <Grid2x2Plus />
          Publicar Vaga
        </RouterLink>
      </div>

      <div class="flex gap-2">
        <RouterLink to="/bug_report" class="sidebar_item_exit">
          <Bug />
          Bug
        </RouterLink>
        <RouterLink @click="Sair()" to="/" class="sidebar_item_exit">
          <LogOut />
          Sair
        </RouterLink>
      </div>
    </section>
  </aside>
</template>

<script>
import { Bug, LogOut, UserCog, Grid2x2Plus } from "lucide-vue-next";
import axios from "axios";
import { RouterLink } from "vue-router";

export default {
  components: { Bug, LogOut, UserCog, Grid2x2Plus },
  data() {
    return {
      company: {
        name: "",
        cnpj: "",
      },
    };
  },
  mounted() {
    this.LoggedCompany();
  },
  methods: {
    LoggedCompany() {
      const companyId = this.$route.params.id;

      axios
        .get(`http://localhost:8001/api/companies/${companyId}`)
        .then(({ data }) => {
          this.company.cnpj = data.cnpj;
          this.company.name = data.name;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    Sair() {
      const companyId = this.$route.params.id;

      localStorage.removeItem("companyId");
    },
  },
};
</script>
