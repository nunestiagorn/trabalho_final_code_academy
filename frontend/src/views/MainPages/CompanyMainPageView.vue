<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <Sidebar />

    <section
      class="h-full w-full flex flex-col items-center overflow-y-scroll p-5 gap-5"
    >
      <h1 class="text-5xl font-bold drop-shadow-textShadow2 py-4">
        Suas Vagas Publicadas
      </h1>
      <section
        v-if="jobs.length > 0"
        class="flex gap-4 flex-wrap justify-center"
      >
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
                @click="abrirModalCandidate(job)"
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
      <section v-else>
        <p class="text-center text-2xl font-bold mt-14">
          Ops! Parece que sua empresa ainda não possui vagas publicadas!
        </p>
        <div class="absolute top-[23.25rem] left-72 text-2xl font-bold flex gap-2 items-center">
          <ArrowLeft class="size-14"/>
          <p>Publique a sua vaga por aqui!</p>
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

          <hr class="w-full border-b-2 border-gray-800 rounded-full" />

          <div class="flex gap-2 items-center text-xl -mb-3 ml-2">
            <h2 class="">Salário:</h2>
            <input
              type="text"
              @input="formatSalary"
              v-model="selectedJob.salary"
              placeholder="Salário da vaga..."
              maxlength="10"
              minlength="4"
              class="p-2 w-5/12 bg-gray-300 text-gray-900 text-lg shadow-[inset_0_0_12px_-2px_rgba(0,0,0,0.75)] rounded-lg"
            />
          </div>

          <h2 class="ml-2">Detalhes da vaga:</h2>
          <textarea
            type="text"
            v-model="selectedJob.description"
            placeholder="Descrição da vaga..."
            maxlength="500"
            minlength="20"
            class="overflow-y-auto resize-none text-justify textoDescricao min-h-40 w-full bg-gray-300 text-gray-700 text-lg shadow-[inset_0_0_10px_1px_rgba(0,0,0,0.75)] rounded-lg p-4 break-words"
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
        <div
          v-if="candidates.length > 0"
          class="flex flex-col gap-4 max-h-72 overflow-y-scroll"
        >
          <h3 class="text-2xl font-bold">Candidatos:</h3>
          <div
            v-for="candidate in candidates"
            :key="candidate.id"
            class="flex justify-between items-center p-2 border-b-2 border-black"
          >
            <div class="flex flex-col">
              <div class="flex gap-2 items-center">
                <span class="font-semibold">| {{ candidate.userName }}</span>
                <p class="text-gray-600 text-sm">{{ candidate.userEmail }}</p>
              </div>
              <button
                @click="openCurriculum(candidate.user_id)"
                class="mt-3 bg-blue-500 max-w-36 text-white py-1 px-3 rounded-lg hover:bg-blue-700"
              >
                Ver Currículo
              </button>
            </div>

            <div class="flex gap-2 items-center">
              <h2>Status:</h2>
              <select
                v-model="candidate.status"
                @change="updateStatus(candidate)"
                class="py-1.5 px-2.5   rounded-full focus:outline-none bg-zinc-400"
              >
                <option value="pending">Pendente</option>
                <option value="approved">Aprovado</option>
                <option value="repproved">Rejeitado</option>
              </select>
            </div>
          </div>
        </div>
        <div v-else>
          <p>Nenhum candidato encontrado para essa vaga.</p>
        </div>
      </template>
    </ModalCandidate>
  </main>
</template>

<script>
import Sidebar from "@/components/sidebars/CompanySidebar.vue";
import ModalJobDetail from "@/components/Modals/JobDetailsModal.vue";
import ModalCandidate from "@/components/Modals/CandidateModal.vue";
import axios from "axios";
import { FileUser, ArrowLeft } from "lucide-vue-next";
import { useRoute } from "vue-router";
import "vue3-toastify/dist/index.css";
import { toast } from "vue3-toastify";

const Toast = (mensagem, type) => {
  toast(mensagem, {
    type: type,
    autoClose: 2500,
    multiple: false,
    position: "top-center",
    toastStyle: {
      fontSize: "22px",
    },
  });
};

export default {
  components: {
    Sidebar,
    FileUser,
    ArrowLeft,
    ModalJobDetail,
    ModalCandidate,
  },
  data() {
    return {
      jobs: [],
      candidates: [],
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
    async getCandidates() {
      try {
        const { data } = await axios.get(
          `http://localhost:8001/api/applications`,
          {
            params: { opening_id: this.selectedJob.id },
          }
        );
        console.log(data);

        if (Array.isArray(data)) {
          const candidates = await Promise.all(
            data.map(async (application) => {
              const userData = await axios.get(
                `http://localhost:8001/api/users/${application.user_id}`
              );
              return {
                ...application,
                userName: userData.data.name,
                userEmail: userData.data.email,
                userCurriculum: userData.data.curriculum,
              };
            })
          );
          this.candidates = candidates;
        } else {
          console.error("Formato de dados inválido:", data);
          this.candidates = [];
        }
      } catch (error) {
        console.error("Erro ao buscar os candidatos:", error);
      }
    },
    openCurriculum(user_id) {
      const pdfUrl = `http://localhost:8001/api/users/${user_id}/curriculum`;
      window.open(pdfUrl, '_blank');
    },
    async updateStatus(candidate) {
      try {
        const response = await axios.put(
          `http://localhost:8001/api/applications/${candidate.id}`,
          {
            status: candidate.status,
          }
        );

        const index = this.candidates.findIndex((c) => c.id === candidate.id);
        if (index !== -1) {
          this.candidates[index].status = candidate.status;
        }

        Toast("Status atualizado com sucesso!", "success");
      } catch (error) {
        console.error("Erro ao atualizar o status do candidato:", error);
        Toast("Erro ao atualizar o status do candidato :(", "error");
      }
    },
    abrirModalJobDetails(job) {
      this.selectedJob = job;
      this.VisivelJobDetail = true;
    },
    closeModal() {
      this.VisivelJobDetail = false;
    },
    abrirModalCandidate(job) {
      this.selectedJob = job;
      if (this.selectedJob && this.selectedJob.id) {
        this.getCandidates();
        this.VisivelCandidate = true;
      } else {
        console.error("Nenhuma vaga selecionada.");
      }
    },
    excluirVaga() {
      axios
        .delete(`http://localhost:8001/api/job_openings/${this.selectedJob.id}`)
        .then((response) => {
          this.jobs = this.jobs.filter((job) => job.id !== this.selectedJob.id);

          this.closeModal();
          Toast("Vaga excluída com sucesso!", "success");
        })
        .catch((error) => {
          console.error("Erro ao excluir a vaga:", error);
          Toast("Ocorreu um erro ao excluir a vaga.", "error");
        });
    },
    editarVaga() {
      const salarioNumerico = Number(
        this.selectedJob.salary.replace(/\D/g, "")
      );

      if (salarioNumerico < 100000) {
        Toast("O salário não pode ser menor que R$ 1.000,00", "error");
        return;
      }

      axios
        .put(`http://localhost:8001/api/job_openings/${this.selectedJob.id}`, {
          description: this.selectedJob.description,
          salary: this.selectedJob.salary,
        })
        .then((response) => {
          const updatedJob = this.jobs.find(
            (job) => job.id === this.selectedJob.id
          );
          if (updatedJob) {
            updatedJob.description = this.selectedJob.description;
            updatedJob.salary = this.selectedJob.salary;
          }

          this.closeModal();
          Toast("Vaga atualizada com sucesso!", "success");
        })
        .catch((error) => {
          console.error("Erro ao atualizar vaga:", error);
          Toast("Ocorreu um erro ao atualizar a vaga.", "error");
        });
    },
    formatSalary(event) {
      const value = event.target.value.replace(/\D/g, "");
      const formatted = (Number(value) / 100).toLocaleString("pt-BR", {
        maximumFractionDigits: 2,
      });

      this.selectedJob.salary = formatted;

      if (salary < 100000) {
        this.selectedJob.salary = "1.000,00";
        Toast("O salário não pode ser menor que R$ 1.000,00", "error");
      } else {
        this.selectedJob.salary = formatted;
      }
    },
  },
  created() {
    const route = useRoute();
    this.getJobs(route.params.id);
  },
};
</script>
