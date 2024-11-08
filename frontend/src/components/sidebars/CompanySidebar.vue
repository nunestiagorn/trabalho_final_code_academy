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
        <div
          class="-mt-1.5 flex flex-col text-black capitalize items-center gap-1"
        >
          <h2 class="font-bold text-xl underline underline-offset-4">
            {{ company.name }}
          </h2>

          <div
            class="flex flex-col gap-0.5 text-center mt-1.5 text-lg bg-white px-2.5 py-1 rounded-lg shadow-lg font-medium"
          >
            <p>Recrutador:</p>
            <p>{{ company.recruiter_name }}</p>
          </div>
        </div>
      </div>
    </div>

    <hr class="border-px border-zinc-500 w-11/12" />

    <section
      class="flex flex-col justify-between h-full w-full px-4 font-semibold text-zinc-200 text-lg"
    >
      <div class="flex flex-col gap-5">
        <button @click.prevent="abrirModal()" class="company_sidebar_item">
          <UserCog />
          Editar Recrutador
        </button>

        <RouterLink to="/publish" class="company_sidebar_item">
          <Grid2x2Plus />
          Publicar Vaga
        </RouterLink>

        <RouterLink to="/help" class="company_sidebar_item">
          <Info />
          Ajuda
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

    <ModalRecruiter :visivel="Visivel" @close="Visivel = false">
      <template #headerRecruiter>
        Editar o Recrutador da empresa: {{ company.name }}
      </template>
      <template #bodyRecruiter>
        <div class="flex flex-col gap-4">
          <div class="flex flex-col gap-4">
            <p class="text-2xl font-bold">Altere o Recrutador:</p>
            <input
              v-model="company.recruiter_name"
              class="p-2 rounded-lg outline-none shadow-lg"
              placeholder="Editar Recrutador..."
              maxlength="25"
            />
          </div>

          <button
            @click="saveRecruiter"
            type="submit"
            class="bg-secondaryColor shadow-lg self-end py-1 px-3 rounded-lg text-zinc-200 font-semibold hover:bg-darkBlue transition-all"
          >
            Salvar
          </button>
        </div>
      </template>
    </ModalRecruiter>
  </aside>
</template>

<script>
import { Bug, LogOut, UserCog, Grid2x2Plus, Info } from "lucide-vue-next";
import axios from "axios";
import { RouterLink } from "vue-router";
import ModalRecruiter from "@/components/Modals/RecruiterModal.vue";

export default {
  components: { Bug, LogOut, UserCog, Grid2x2Plus, Info, ModalRecruiter },
  data() {
    return {
      company: {
        id: "",
        name: "",
        cnpj: "",
        recruiter_name: "",
      },
      Visivel: false,
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
          this.company.id = data.id;
          this.company.cnpj = data.cnpj;
          this.company.name = data.name;
          this.company.recruiter_name = data.recruiter_name;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    Sair() {
      localStorage.removeItem("companyId");
    },
    abrirModal() {
      this.Visivel = true;
    },
    saveRecruiter() {
      axios
        .put(`http://localhost:8001/api/companies/${this.company.id}`, {
          name: this.company.name,
          recruiter_name: this.company.recruiter_name,
        })
        .then(() => {
          this.Visivel = false;
          alert("Recrutador atualizado com sucesso!");
        })
        .catch((error) => {
          console.error("Erro ao atualizar recrutador:", error);
        });
    },
  },
};
</script>
