<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <Sidebar />

    <section
      class="h-full w-full flex flex-col items-center overflow-y-scroll p-5 gap-5"
    >
      <h1 class="text-5xl font-bold drop-shadow-textShadow2 py-4">
        Suas Vagas Publicadas
      </h1>
      <section class="flex gap-4 flex-wrap justify-center">
        <div v-for="job in jobs" :key="job.id">
          <div
            class="bg-zinc-200 text-black p-3 shadow-shadow3 rounded-md min-w-64 flex flex-col gap-4"
          >
            <div class="flex flex-col items-center">
              <h1 class="text-xl font-bold capitalize">{{ job.name }}</h1>
              <div class="text-lg text-gray-800 flex gap-2">
                Empresa:
                <h2 class="underline underline-offset-4">
                  {{ job.companyName }}
                </h2>
              </div>
            </div>

            <h2 class="text-gray-800 font-medium">{{ job.description }}</h2>

            <div class="flex justify-between">
              <button
                class="bg-primaryColor self-start text-zinc-200 p-1.5 font-medium rounded-lg hover:bg-secondaryColor transition-all"
              >
                <FileUser />
              </button>

              <button
                class="bg-primaryColor text-zinc-200 px-4 font-medium rounded-lg hover:bg-secondaryColor transition-all"
              >
                Exibir Detalhes
              </button>
            </div>
          </div>
        </div>
      </section>
    </section>
  </main>
</template>

<script>
import Sidebar from "@/components/sidebars/CompanySidebar.vue";
import axios from "axios";
import { FileUser } from "lucide-vue-next";
import { useRoute } from "vue-router";

export default {
  components: {
    Sidebar,
    FileUser,
  },
  data() {
    return {
      jobs: [],
    };
  },
  methods: {
    async getJobs(id) {
      try {
        const { data } = await axios.get(
          `http://localhost:8001/api/job_openings/${id}`
        );

        const jobsId = await Promise.all(
          data.map(async (job) => {
            const companyJobData = await axios.get(
              `http://localhost:8001/api/companies/${job.company_id}`
            );
            return {
              ...job,
              companyName: companyJobData.data.name,
            };
          })
        );

        this.jobs = jobsId;
      } catch (error) {
        console.error("Erro ao buscar as vagas ou o nome das empresas:", error);
      }
    },
  },
  mounted() {
    const route = useRoute();
    const id = route.params.id;

    if (id) {
      this.getJobs(id);
    } else {
      console.error("ID da empresa não encontrado na URL.");
    }
  },
};
</script>
