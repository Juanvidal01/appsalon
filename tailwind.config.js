/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class', // habilita modo oscuro con una clase en <html>
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.{js,vue}',
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50:  '#f0f7ff',
          100: '#e0efff',
          200: '#b9dbff',
          300: '#8ec4ff',
          400: '#5ba6ff',
          500: '#2f86ff', // principal
          600: '#1f6ae6',
          700: '#1a58bf',
          800: '#164b9e',
          900: '#123e82',
        },
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'Segoe UI', 'Roboto', 'sans-serif'],
      },
      boxShadow: {
        card: '0 8px 24px rgba(0,0,0,0.08)',
      },
      borderRadius: {
        '2xl': '1rem',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'), // inputs más lindos
  ],
}
