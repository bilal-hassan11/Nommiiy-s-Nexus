/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    600: "#9155FD",
                    700: "#1c4280",
                    800: "#17386e",
                },

                secondary: "#56CA00",

                gray: {
                    533: "rgb(75 85 99)",
                },
            },
            animation: {
                "pulse-slow": "pulse 2s infinite",
            },
            keyframes: {
                pulse: {
                    "0%, 100%": { opacity: 1 },
                    "50%": { opacity: 0.5 },
                },
            },
        },
    },
    plugins: [],
};
