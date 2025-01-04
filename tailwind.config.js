/** @type {import('tailwindcss').Config} */
export default {
  content: [ 
    // TODO check if this is right 
    './resources/views/**/*.blade.php',  // Include Blade views
    './resources/js/**/*.js',  // Include JavaScript files
    './resources/css/**/*.css',  // Include CSS files
    ],
  theme: {
    extend: {
      colors: {
        white: {
          DEFAULT: '#ffffff',
          100: '#ffffff', // lightest
          200: '#f9f9f9',
          300: '#f2f2f2',
          400: '#e6e6e6',
          500: '#cccccc',
          600: '#b3b3b3',
          700: '#999999',
          800: '#666666',
          900: '#333333', // darkest
        },
        
        gray: {
          DEFAULT: '#c0ccde',
          100: '#f2f5f8', // lightest
          200: '#e6eaf2',
          300: '#d9e0eb',
          400: '#ccd6e4',
          500: '#c0ccde', // default
          600: '#89a0c1',
          700: '#5674a2',
          800: '#394d6c',
          900: '#1d2736', // darkest
        },
        blue: {
          DEFAULT: '#8199bc',
          100: '#e6eaf2', // lightest
          200: '#ccd6e4',
          300: '#b3c1d7',
          400: '#99adca',
          500: '#8199bc', // default
          600: '#5777a6',
          700: '#41597c',
          800: '#2c3b53',
          900: '#161e29', // darkest
        },
      
        darkBlue: {
          DEFAULT: '#023379',
          100: '#b3d2fe', // lightest
          200: '#66a5fd',
          300: '#1a78fc',
          400: '#0354c5',
          500: '#023379', // default
          600: '#012960',
          700: '#011f48',
          800: '#011530',
          900: '#000a18', // darkest
        },
      },
    },
  },
  plugins: [],
}
