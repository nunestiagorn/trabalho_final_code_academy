/** @type {import('tailwindcss').Config} */
export default {
  purge: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  darkMode: false,
  theme: {
    extend: {
      backgroundColor: {
        primaryColor: "#1167b1",
        secondaryColor: "#187bcd",
        darkBlue: "#03254c",
        darkerBlue: "#041d3a",
        lightBlue: "#2a9df4",
        primaryLinear: "bg-gradient-to-r from-sky-600 to-sky-800",
      },
      textColor: {
        darkText: "#03254c",
        secondaryColor: "#187bcd",
      },
      fontSize: {
        title: "4rem",
      },
      borderRadius: {
        blob1: "30% 70% 59% 41% / 64% 36% 64% 36%",
        blob2: "39% 61% 49% 51% / 52% 57% 43% 48% ",
      },
      boxShadow: {
        neumorfismo1: "7px 7px 9px #010f1e, -4px -4px 9px #053b7a",
        shadow1: "0px 0px 6px 7px rgba(0 ,0 ,0, 0.6)",
        shadow2: "0 0 6px 4px rgba(0 ,0 ,0, 0.75)",
        shadow3: "0 0 4px 2px rgba(0 ,0 ,0, 0.75)",
        inset1: "inset 0 0 12px 4px rgba(0 ,0 ,0, 0.75)",
      },
      dropShadow: {
        imageShadow1: "0 4px 1px rgba(0, 0, 0, 0.6)",
        imageShadow2: "0 0 12px rgba(0, 0, 0, 0.75)",
        textShadow: "-1px 1px 1px rgb(0, 0, 0)",
        textShadow2: "-2px 2px 1px rgb(0, 0, 0)",
      },
      width: {
        18: "4.5rem",
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
};
