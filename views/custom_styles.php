<style>
        /* shut up red local non-https warning */
        div[style="background: red; color: white; padding: 10px; position: fixed; bottom: 0px; width: 100%; text-align: center; z-index: 1000;"] {
            display: none !important;
        }
        /* Scanline overlay */
            .scanlines {
            background: repeating-linear-gradient(
                to bottom,
                rgba(0, 255, 0, 0.1) 0px,
                rgba(0, 255, 0, 0.1) 4px,
                transparent 4px,
                transparent 8px
            );
            background-size: 100% 16px; /* ensures visible vertical repetition */
            animation: scan 0.5s linear infinite; /* fast movement */
            }

            @keyframes scan {
            0% { background-position: 0 0; }
            100% { background-position: 0 16px; } /* move one full pattern height */
            }

            /* WebKit browsers (Chrome, Edge, Safari) */
            /* WebKit browsers (Chrome, Safari, Edge) */
            ::-webkit-scrollbar {
            width: 6px;              /* thin scrollbar */
            }

            ::-webkit-scrollbar-track {
            background: #000;        /* black track */
            }

            ::-webkit-scrollbar-thumb {
            background-color: #458B41; /* dark green thumb */
            border-radius: 3px;
            }

            /* Firefox */
            * {
            scrollbar-width: thin;
            scrollbar-color: #458B41 #000; /* thumb track */
            }
    </style>