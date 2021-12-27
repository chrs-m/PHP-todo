module.exports = {
    content: ['./public/**/*.{php,js}'],
    theme: {
        extend: {
            keyframes: {
                wiggle: {
                    '0%, 100%': { transform: 'rotate(-3deg)' },
                    '50%': { transform: 'rotate(3deg)' },
                },

                opacity: {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
            },
            animation: {
                wiggle: 'wiggle 1s ease-in-out infinite',
                opacity: 'opacity 0.35s ease-in-out',
            },
        },
    },
    plugins: [],
};
