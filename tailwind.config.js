/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{js,jsx,ts,tsx,html}", // Ajusta esto según tus necesidades
  ],
  theme: {
    extend: {
      colors: {
        lightBlue: {
          500: "#D1DDEF",
          700: "#9cb5db",
        },
        darkBlue: {
          500: "#0D3C89",
        },
        lighterBlue: {
          500: "#E7EEF8",
          700: "#9da5b0",
        },
        lightGray: {
          500: "#F5F3F1",
        },
        blue: {
          500: "#126AFB",
        },
        pastelBlue: {
          500: "#F6F6F6",
        },
        customGreen: "#43B923",
      },
      fontFamily: {
        sans: ["Arial", "sans-serif"],
      },
    },
  },
  plugins: [],
};
