<template>
  <main class="h-screen w-full flex items-center justify-center">
    <div class="flex font-bold text-2xl absolute top-6 left-50">
      <RouterLink
        to="/"
        class="pl-3 pr-4 py-2.5 hover:text-zinc-300 bg-primaryColor rounded-[100px] hover:bg-darkBlue transition-all items-center duration-150 shadow-xl flex gap-0.5 hover:rounded-xl"
      >
        <ArrowLeft />
        Home
      </RouterLink>
    </div>

    <div
      class="flex flex-col items-center justify-center gap-12 p-6 bg-zinc-300 w-8/12 shadow-2xl"
    >
      <section class="flex gap-2 items-center justify-between w-full">
        <h2 class="text-black text-5xl font-semibold">Tiago Remes Nunes</h2>
        <div class="flex gap-12">
          <a
            href="https://github.com/nunestiagorn"
            class="border-4 border-black rounded-xl hover:bg-violet-800 p-3 transition-all"
          >
            <Github class="size-12 text-black ml-0.5" />
          </a>
          <a
            href="https://gitlab.com/nunestiagorn"
            class="border-4 border-black rounded-xl hover:bg-amber-600 p-3 transition-all"
          >
            <Gitlab class="size-12 text-black ml-0.5" />
          </a>
          <a
            href="https://www.linkedin.com/in/tiagoremesnunes/"
            class="border-4 border-black rounded-xl hover:bg-blue-700 p-3 transition-all"
          >
            <Linkedin class="size-12 text-black ml-0.5" />
          </a>
        </div>
      </section>

      <hr class="w-full border-black border-2 rounded-full"/>

      <section class="flex gap-2 items-center justify-between w-full">
        <h2 class="text-black text-5xl font-semibold">Enzo Rocha e Silva</h2>
        <div class="flex gap-12">
          <a
            href="https://github.com/elziorocha"
            class="border-4 border-black rounded-xl hover:bg-violet-800 p-3 transition-all"
          >
            <Github class="size-12 text-black ml-0.5" />
          </a>
          <a
            href="https://gitlab.com/elziorocha"
            class="border-4 border-black rounded-xl hover:bg-amber-600 p-3 transition-all"
          >
            <Gitlab class="size-12 text-black ml-0.5" />
          </a>
          <a
            href="https://www.linkedin.com/in/elziorocha/"
            class="border-4 border-black rounded-xl hover:bg-blue-700 p-3 transition-all"
          >
            <Linkedin class="size-12 text-black ml-0.5" />
          </a>
        </div>
      </section>
    </div>
  </main>
</template>

<script>
import { Github, Linkedin, Gitlab, ArrowLeft } from "lucide-vue-next";

export default {
  components: {
    Github,
    Linkedin,
    Gitlab,
    ArrowLeft
  },
};
</script>
