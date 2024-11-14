<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <div class="flex font-bold text-lg absolute top-4 left-4">
      <RouterLink
        to="/:id/mainpage"
        class="pl-3 pr-4 py-2.5 hover:text-zinc-300 bg-darkBlue rounded-[100px] hover:bg-darkerBlue transition-all items-center duration-150 shadow-xl flex gap-0.5 hover:rounded-xl"
      >
        <ArrowLeft />
        Mainpage
      </RouterLink>
    </div>

    <section
      class="h-full w-full flex flex-col items-center overflow-y-scroll p-5 gap-5"
    >
      <h1 class="text-5xl py-4 font-bold drop-shadow-textShadow2">
        Vagas Disponíveis
      </h1>
      <div class="flex gap-4 flex-wrap justify-center">
        <div v-for="job in jobs" :key="job.id">
          <div
            @click.prevent="abrirModalJobDetails(job)"
            class="bg-zinc-200 capitalize py-3 px-4 text-black cursor-pointer flex flex-col gap-2 rounded-xl shadow-xl max-w-72 min-w-72 hover:scale-105 transition-all"
          >
            <h2 class="text-center text-2xl font-bold">{{ job.name }}</h2>
            <div class="flex flex-col justify-between text-lg">
              <h3 class="font-semibold">Empresa: {{ job.companyName }}</h3>
              <div class="text-gray-700 flex gap-2">
                <h3>Recrutador:</h3>
                <h3 class="underline underline-offset-2">
                  {{ job.recruiter }}
                </h3>
              </div>
            </div>
            <p
              class="p-4 bg-neutral-300 text-sm font-medium italic rounded-lg shadow-lg"
            >
              {{ job.description }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <Sidebar />

    <ModalJobDetail
      :visivel="VisivelJobDetail"
      @close="VisivelJobDetail = false"
    >
      <template #headerJobDetail>
        <div class="flex gap-2">
          <p>Detalhes da Vaga de:</p>
          <p class="underline underline-offset-4 capitalize">
            {{ selectedJob?.name }}
          </p>
        </div>
      </template>
      <template #bodyJobDetail>
        <div v-if="selectedJob" class="flex flex-col gap-4">
          <div class="flex flex-col gap-2 text-[1.35rem]">
            <div class="flex justify-between">
              <span>Empresa: {{ selectedJob.companyName }}</span>
              <span class="text-gray-800 text-lg"
                >CNPJ: {{ selectedJob.companyCNPJ }}</span
              >
            </div>
            <span>Recrutador: {{ selectedJob.recruiter }}</span>
          </div>

          <h2 class="-mb-3 ml-2 mt-4">Detalhes da vaga:</h2>
          <p
            class="overflow-y-scroll bg-gray-300 text-gray-700 text-lg shadow-[inset_0_0_10px_1px_rgba(0,0,0,0.75)] rounded-lg p-4"
          >
            {{ selectedJob.description }}
          </p>
        </div>
      </template>
    </ModalJobDetail>
  </main>
</template>

<script>
import ModalJobDetail from "@/components/Modals/JobDetailsModal.vue";
import Sidebar from "@/components/sidebars/UserSidebar.vue";
import axios from "axios";
import { ArrowLeft } from "lucide-vue-next";

export default {
  components: {
    Sidebar,
    ModalJobDetail,
    ArrowLeft,
  },
  data() {
    return {
      jobs: [],
      VisivelJobDetail: false,
      selectedJob: null,
    };
  },
  mounted() {
    this.JobViews();
  },
  methods: {
    async JobViews() {
      try {
        const { data: jobsData } = await axios.get(
          "http://localhost:8001/api/job_openings/"
        );

        const companyInfo = await Promise.all(
          jobsData.map(async (job) => {
            const { data: companyData } = await axios.get(
              `http://localhost:8001/api/companies/${job.company_id}`
            );
            return {
              ...job,
              companyName: companyData.name,
              recruiter: companyData.recruiter_name,
              companyCNPJ: companyData.cnpj,
            };
          })
        );

        this.jobs = companyInfo;
      } catch (error) {
        console.error("Erro ao buscar os jobs:", error);
      }
    },
    abrirModalJobDetails(job) {
      this.selectedJob = job;
      this.VisivelJobDetail = true;
    },
  },
};
</script>
