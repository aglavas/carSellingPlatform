const colors = require('tailwindcss/colors')

module.exports = {
  purge: [
      './resources/**/*.blade.php'
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    fontFamily: {
        'sans': '"Lato", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"'
    },
    extend: {
        animation: {
            'ping-once': 'ping 1s cubic-bezier(0, 0, 0.2, 1) 1'
        }
    },
      colors: {
          transparent: 'transparent',
          current: 'currentColor',
          black: colors.black,
          white: colors.white,
          gray: colors.coolGray,
          green: colors.emerald,
          indigo: colors.indigo,
          red: colors.red,
          blue: colors.blue,
          yellow: colors.amber,
          orange: colors.orange,
          'light-blue': colors.lightBlue,
          cyan: colors.cyan,
      }
  },
  variants: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/typography'),
      require('@tailwindcss/aspect-ratio'),
      require('tailwindcss-font-inter')
  ],
}
