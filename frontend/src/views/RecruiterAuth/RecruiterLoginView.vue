<template>
  <main class="bg-recruiter h-screen bg-primaryColor flex flex-col items-center justify-center gap-8">
    <div class="bg-darkerBlue p-12 w-5/12 items-center justify-center flex flex-col gap-8 border-4
      border-black rounded-xl shadow-shadow2">

      <div class="flex gap-2 items-center">
        <img src="../../assets/images/logo.png" alt="Logo do site" class="size-14" />
        <h2 class="text-2xl font-semibold italic">Insira os dados de sua empresa</h2>
      </div>
      
      <form action="" class="w-full flex justify-evenly items-center gap-2">
        <div class="flex flex-col gap-8 w-5/6">
          <div class="flex items-center border-b-2 border-black">
            <Building2 class="ml-2" />
            <input type="text" class="input2" placeholder="Insira o CNPJ" v-model="cnpj" @input="formatCNPJ"
              maxlength="18" />
          </div>

          <div class="flex items-center border-b-2 border-black">
            <LockKeyhole class="ml-2" />
            <input type="password" class="input2" placeholder="Sua Senha" />
          </div>
        </div>

        <button class="p-4 bg-darkBlue rounded-full ml-9 group shadow-shadow3">
          <ArrowRight class="size-6 group-hover:translate-x-1.5 transition-all" />
        </button>
      </form>

      <div class="flex flex-col self-start ml-2">
        <h2>Não possui empresa cadastrada?</h2>
        <div class="group flex gap-1">
          <RouterLink to="/recruiter-register" class="underline underline-offset-4 hover:text-secondaryColor ">
            <p>Cadastre Já!</p>
          </RouterLink>
          <ArrowRight class="size-5 self-center group-hover:translate-x-2 transition-all duration-150" />
        </div>
      </div>
    </div>

    <div class="flex font-bold text-xl absolute bottom-6 left-6">
      <RouterLink to="/" class="pl-3 pr-4 py-3 hover:text-zinc-300 bg-secondaryColor rounded-[100px] hover:bg-primaryColor transition-all
        items-center duration-150 shadow-xl flex gap-0.5 hover:rounded-xl">
        <ArrowLeft />
        Home
      </RouterLink>
    </div>
  </main>
</template>

<script setup>
import { ref } from 'vue';
import { Building2, LockKeyhole, ArrowRight, ArrowLeft } from 'lucide-vue-next';

const cnpj = ref('');

function formatCNPJ() {

  let value = cnpj.value.replace(/\D/g, '');
  value = value.slice(0, 14);

  if (value.length <= 14) {
    value = value.replace(/^(\d{2})(\d)/, '$1.$2');
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
    value = value.replace(/(\d{4})(\d)/, '$1-$2');
  }

  cnpj.value = value;
}
</script>
