<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <section
      class="h-full w-full flex flex-col items-center overflow-y-scroll p-5 gap-5"
    >
      <h1 class="text-5xl py-4 font-bold drop-shadow-textShadow2">
        Suas Candidaturas
      </h1>
      <div
        v-if="applications.length > 0"
        class="flex gap-4 flex-wrap justify-center"
      >
        <div v-for="application in applications" :key="application.id">
          <div
            @click.prevent="abrirModalJobDetails(application)"
            class="userCardMain relative"
          >
            <h2 class="text-center text-[1.35rem] font-bold">
              {{ application.jobName }}
            </h2>
            <div class="flex flex-col justify-between text-lg mb-5">
              <h3 class="font-semibold">
                Empresa: {{ application.companyName }}
              </h3>
              <div class="text-gray-700 flex gap-2">
                <h3>Recrutador:</h3>
                <h3 class="underline underline-offset-2">
                  {{ application.recruiterName }}
                </h3>
              </div>
              <div class="self-end -mb-4 mt-1 p-1">
                <div
                  class="flex items-center gap-2 text-red-500 font-bold text-xl"
                  v-if="application.status === 'repproved'"
                >
                  <h2>Reprovado :(</h2>
                  <X class="size-8" stroke-width="5" />
                </div>

                <div
                  class="flex items-center gap-2 text-green-500 font-bold text-xl"
                  v-if="application.status === 'approved'"
                >
                  <h2>Aprovado!!</h2>
                  <Check class="size-8" stroke-width="5" />
                </div>

                <div
                  class="flex items-center gap-2 text-orange-500 font-bold text-xl"
                  v-if="application.status === 'pending'"
                >
                  <h2>Em Análise...</h2>
                  <Hourglass class="size-8" stroke-width="4" />
                </div>
              </div>
            </div>
            <div
              :class="{
                'bg-orange-500': application.status === 'pending',
                'bg-green-500': application.status === 'approved',
                'bg-red-500': application.status === 'repproved',
              }"
              class="absolute rounded-b-lg border-t-2 border-black bottom-0 left-0 w-full h-[0.85rem]"
            ></div>
          </div>
        </div>
      </div>
      <div v-else>
        <p class="text-2xl font-bold mt-16 text-center">
          Opa! Parece que você ainda não se candidatou para nenhuma vaga
          disponível!
        </p>
        <div class="absolute right-72 top-[16.35rem] flex gap-2 items-center text-2xl font-bold">
          <p>Candidate-se Aqui!</p>
          <ArrowRight class="size-16"/>
        </div>
      </div>
    </section>

    <Sidebar />
  </main>
</template>

<script>
import Sidebar from "@/components/sidebars/UserSidebar.vue";
import axios from "axios";
import { useRoute } from "vue-router";
import { X, Check, Hourglass, ArrowRight } from "lucide-vue-next";

export default {
  components: {
    Sidebar,
    X,
    Check,
    Hourglass,
    ArrowRight,
  },
  data() {
    return {
      applications: [],
    };
  },
  methods: {
    async getCompanyName(companyId) {
      try {
        const { data } = await axios.get(
          `http://localhost:8001/api/companies/${companyId}`
        );
        return data.name;
      } catch (error) {
        console.log("Erro ao carregar o nome da empresa", error);
        return "Empresa não encontrada";
      }
    },

    async getApplications(userId) {
      try {
        const { data } = await axios.get(
          `http://localhost:8001/api/applications`,
          {
            params: { user_id: userId },
          }
        );

        this.applications = await Promise.all(
          data.map(async (application) => {
            const companyName = await this.getCompanyName(
              application.company_id
            );

            return {
              ...application,
              recruiterName: application.recruiter_name,
              companyName: companyName,
              jobName: application.job_name,
            };
          })
        );
      } catch (error) {
        console.log("Erro ao carregar candidaturas", error);
      }
    },
  },
  mounted() {
    const route = useRoute();
    const id = route.params.id;

    if (id) {
      this.getApplications(id);
    } else {
      console.log("ID da candidatura não encontrada na URL.");
    }
  },
};
</script>
