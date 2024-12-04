/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./src/tailwind/**/*.css",  // Archivo principal de Tailwind en src/tailwind
    "./views/**/*.php",         // Archivos de vistas PHP
    "./public/**/*.php",        // Otros archivos PHP en public (por si se usanclases de Tailwind aquí)
    "./public/**/*.html",       // Archivos HTML en public 
    
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin') // Agrega Flowbite como plugin
  ],
}

