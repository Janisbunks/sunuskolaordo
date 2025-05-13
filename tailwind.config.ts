// https://tailwindcss.com/docs/configuration
import type { Config } from 'tailwindcss';
import forms from '@tailwindcss/forms';

export default {
  content: [
    './app/**/*.php',
    './resources/**/*.{php,js,ts,tsx,vue}',
    './resources/views/**/*.php',
    './public/content/themes/radicle/index.php',
  ],
  theme: {
    screens: {
      sm: '600px',
      md: '768px',
      lg: '1024px',
      xl: '1280px',
    },
    container: {
      center: true,
      padding: "1rem",
    },
    body: {
      padding: "0px",
    },
    backgroundImage: {
      'hero': "url('/images/backgrounds/bg-hero.jpg?as=webp')",
    },
    extend: {
      colors: {
        inherit: 'inherit',
        current: 'currentColor',
        transparent: 'transparent',
        black: '#000',
        white: '#FFF',
      },
      fontFamily: {
        source: ['"Source Serif 4"', "Source Serif Pro", "serif"],
      },
      fontSize: {
        'h2': ['20px', { lineHeight: '130%' }],
        'md:h2': ['24px', { lineHeight: '130%' }],
      },
      borderRadius: {
        sm: '40px',
        md: '60px',
        lg: '80px',
      },
      borderWidth: {
        '3': '3px',
      },
    },
  },
  plugins: [
    forms,
  ],
} satisfies Config;
