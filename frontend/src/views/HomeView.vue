<template>
  <main class="px-10 py-4 flex flex-col justify-between gap-10 bg-cover">
    <div class="flex justify-between items-center">
      <div class="flex gap-4 items-center">
        <img
          src="../assets/images/logo.png"
          alt="Logo da página"
          class="w-20 drop-shadow-imageShadow1"
        />
        <h1
          class="text-zinc-200 text-5xl font-semibold drop-shadow-imageShadow1 italic"
        >
          Pampa's RH
        </h1>
      </div>
      <nav class="flex gap-8 items-center font-bold text-xl">
        <RouterLink to="/about" class="navHover">Sobre nós</RouterLink>
        <RouterLink to="/contact" class="navHover">Contato</RouterLink>
        <RouterLink to="/company-login" class="navHover"
          >Seja um recrutador</RouterLink
        >
        <RouterLink
          to="/login"
          class="px-5 py-2.5 bg-lightBlue rounded-full hover:bg-darkBlue transition-all duration-150 shadow-xl flex gap-1"
        >
          Login
          <User stroke-width="3px" />
        </RouterLink>
      </nav>
    </div>
    <section class="w-full flex gap-72 h-[30rem]">
      <div class="mt-16 w-7/12 flex flex-col gap-4">
        <h1 class="text-title font-bold drop-shadow-textShadow2">
          Seja Bem-Vindo(a)!!!
        </h1>
        <h2 class="w-10/12 font-medium text-xl drop-shadow-textShadow -mt-4">
          Nós somos a Pampa's RH, o melhor sistema de gerenciamento e procura de
          vagas disponível no mercado!
        </h2>
        <div class="flex items-center justify-start text-lg gap-4">
          <RouterLink
            to="/login"
            class="px-5 py-2.5 bg-lightBlue rounded-full hover:bg-darkBlue transition-all duration-200 shadow-md font-semibold flex gap-1"
          >
            <User stroke-width="3px" />
            Login
          </RouterLink>
          <RouterLink
            to="/company-login"
            class="px-5 py-2.5 rounded-full transition-all duration-200 shadow-md font-semibold border-2 border-zinc-300 hover:bg-secondaryColor hover:border-sky-900"
          >
            Contrate agora
          </RouterLink>
        </div>
      </div>

      <div class="drop-shadow-imageShadow2">
        <img
          src="../assets/images/HomeImage1.jpg"
          alt=""
          class="clip-home home-image relative right-24 bottom-7 z-10"
        />
        <div class="job-icons bottom-[28rem] right-28">
          <FileUser color="#ffd91a" size="56px" />
        </div>
        <div class="job-icons bottom-96 left-44">
          <Search color="#e60000" size="56px" />
        </div>
        <div class="job-icons bottom-72 right-14">
          <BriefcaseBusiness color="#000" size="56px" />
        </div>
      </div>
    </section>
    <footer class="flex flex-col items-center justify-center">
      <p>2024 | ©Copyright for the Developers in this project</p>
      <div class="flex gap-2">
        <p>Enzo Rocha</p>
        -
        <p>Tiago Remes</p>
      </div>
    </footer>
  </main>
</template>

<script setup>
import { User, FileUser, Search, BriefcaseBusiness } from "lucide-vue-next";
</script>
