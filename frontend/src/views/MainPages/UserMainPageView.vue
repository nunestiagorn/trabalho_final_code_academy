<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <section
      class="h-full w-full flex flex-col items-center overflow-y-scroll p-5 gap-5"
    >
      <h1 class="text-5xl py-4 font-bold drop-shadow-textShadow2">
        Suas Candidaturas
      </h1>
      <div class="flex gap-4 flex-wrap justify-center">
        <div v-for="application in applications" :key="application.id">
          <div
            @click.prevent="abrirModalJobDetails(application)"
            class="bg-zinc-200 capitalize py-3 px-4 text-black cursor-pointer flex flex-col gap-2 rounded-xl shadow-xl max-w-72 min-w-72 hover:scale-105 transition-all"
          >
            <h2 class="text-center text-2xl font-bold">{{ application.jobName }}</h2>
            <div class="flex flex-col justify-between text-lg">
              <h3 class="font-semibold">Empresa: {{ application.companyName }}</h3>
              <div class="text-gray-700 flex gap-2">
                <h3>Recrutador:</h3>
                <h3 class="underline underline-offset-2">
                  {{ application.recruiterName }}
                </h3>
              </div>
              <p class="mt-2 text-gray-600">{{ application.jobDescription }}</p>
            </div>
          </div>
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

export default {
  components: {
    Sidebar,
  },
  data() {
    return {
      applications: [],
    };
  },
  methods: {
    async getCompanyName(companyId) {
      try {
        const { data } = await axios.get(`http://localhost:8001/api/companies/${companyId}`);
        return data.name;
      } catch (error) {
        console.log("Erro ao carregar o nome da empresa", error);
        return "Empresa não encontrada";
      }
    },
    
    async getApplications(userId) {
      try {
        const { data } = await axios.get(`http://localhost:8001/api/applications`, {
          params: { user_id: userId },
        });

        this.applications = await Promise.all(
          data.map(async (application) => {
            const companyName = await this.getCompanyName(application.company_id);

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

