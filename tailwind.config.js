const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  purge: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue'
  ],
  theme: {
    extend: {
      colors: {
        jets: {
          50: '#EFF1FE',
          100: '#E0E3FD',
          200: '#C2C7FB',
          300: '#A4ACF9',
          400: '#8690F7',
          500: '#6875F5',
          600: '#5D69DC',
          700: '#535DC4',
          800: '#3E4693',
          900: '#292E62'
        }
      },
      fontFamily: {
        sans: ['Nunito', ...defaultTheme.fontFamily.sans]
      }
    }
  },
  variants: {
    extend: {
      opacity: ['disabled']
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography')
  ]
};
