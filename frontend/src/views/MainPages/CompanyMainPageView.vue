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

            <h2
              class="text-gray-800 font-medium text-md p-2 bg-zinc-300 rounded-lg shadow-inner"
            >
              {{
                job.description.length > 20
                  ? job.description.slice(0, 20) + "..."
                  : job.description
              }}
            </h2>

            <div class="flex justify-between">
              <button
                @click="abrirModalCandidate"
                class="bg-primaryColor self-start text-zinc-200 p-1.5 font-medium rounded-lg hover:bg-secondaryColor transition-all"
              >
                <FileUser />
              </button>

              <button
                @click="abrirModalJobDetails(job)"
                class="bg-primaryColor text-zinc-200 px-4 font-medium rounded-lg hover:bg-secondaryColor transition-all"
              >
                Exibir Detalhes
              </button>
            </div>
          </div>
        </div>
      </section>
    </section>

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
          <textarea
            type="text"
            v-model="selectedJob.description"
            placeholder="Descrição da vaga..."
            maxlength="500"
            minlength="20"
            class="overflow-y-auto resize-none textoDescricao min-h-40 w-full bg-gray-300 text-gray-700 text-lg shadow-[inset_0_0_10px_1px_rgba(0,0,0,0.75)] rounded-lg p-4 break-words"
          />
        </div>
      </template>

      <template #buttonsJobDetail>
        <button
          type="submit"
          @click.prevent="excluirVaga"
          class="bg-red-600 active:scale-75 shadow-lg py-1 px-3 text-lg rounded-lg text-zinc-200 font-semibold hover:bg-red-800 transition-all"
        >
          Excluir Vaga
        </button>
        <button
          type="submit"
          @click.prevent="editarVaga"
          class="bg-orange-600 active:scale-75 shadow-lg py-1 px-3 text-lg rounded-lg text-zinc-200 font-semibold hover:bg-orange-800 transition-all"
        >
          Editar Vaga
        </button>
        <button
          @click.prevent="closeModal"
          class="bg-primaryColor p-1.5 px-2.5 rounded-lg shadow-lg text-lg text-zinc-200 font-semibold hover:bg-darkBlue transition-all"
        >
          Fechar
        </button>
      </template>
    </ModalJobDetail>

    <ModalCandidate
      :visivel="VisivelCandidate"
      @close="VisivelCandidate = false"
    >
      <template #headerCandidate>
        <p>Candidatos da Vaga</p>
      </template>
      <template #bodyCandidate>
        teste
      </template>
    </ModalCandidate>
  </main>
</template>

<script>
import Sidebar from "@/components/sidebars/CompanySidebar.vue";
import ModalJobDetail from "@/components/Modals/JobDetailsModal.vue";
import ModalCandidate from "@/components/Modals/CandidateModal.vue";
import axios from "axios";
import { FileUser } from "lucide-vue-next";
import { useRoute } from "vue-router";

export default {
  components: {
    Sidebar,
    FileUser,
    ModalJobDetail,
    ModalCandidate,
  },
  data() {
    return {
      jobs: [],
      VisivelCandidate: false,
      VisivelJobDetail: false,
      selectedJob: null,
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
              companyCNPJ: companyJobData.data.cnpj,
              recruiter: companyJobData.data.recruiter_name,
            };
          })
        );

        this.jobs = jobsId;
      } catch (error) {
        console.error("Erro ao buscar as vagas ou o nome das empresas:", error);
      }
    },
    abrirModalJobDetails(job) {
      this.selectedJob = job;
      this.VisivelJobDetail = true;
    },
    closeModal() {
      this.VisivelJobDetail = false;
    },
    abrirModalCandidate(){
      this.VisivelCandidate = true;
    },
    excluirVaga() {
      axios
        .delete(`http://localhost:8001/api/job_openings/${this.selectedJob.id}`)
        .then((response) => {
          this.jobs = this.jobs.filter((job) => job.id !== this.selectedJob.id);

          this.closeModal();

          alert("Vaga excluída com sucesso!");
        })
        .catch((error) => {
          console.error("Erro ao excluir a vaga:", error);
          alert("Ocorreu um erro ao excluir a vaga.");
        });
    },
    editarVaga() {
      axios
        .put(`http://localhost:8001/api/job_openings/${this.selectedJob.id}`, {
          description: this.selectedJob.description,
        })
        .then((response) => {
          const updatedJob = this.jobs.find(
            (job) => job.id === this.selectedJob.id
          );
          if (updatedJob) {
            updatedJob.description = this.selectedJob.description;
          }

          this.closeModal();
          alert("Vaga atualizada com sucesso!");
        })
        .catch((error) => {
          console.error("Erro ao atualizar vaga:", error);
          alert("Ocorreu um erro ao atualizar a vaga.");
        });
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
