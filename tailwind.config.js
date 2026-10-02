/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#1B4332',
          50: '#E8F0EC',
          100: '#C7DED1',
          600: '#1B4332',
          700: '#153627',
        },
        secondary: {
          DEFAULT: '#40916C',
          100: '#DCEFE4',
        },
        surface: '#B7E4C7',
      },
      borderRadius: {
        card: '16px',
        btn: '12px',
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
      },
      boxShadow: {
        glass: '0 8px 32px 0 rgba(27, 67, 50, 0.15)',
      },
    },
  },
  plugins: [],
}
