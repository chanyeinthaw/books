import React from 'react'
import { render } from 'react-dom'
import { createInertiaApp } from '@inertiajs/inertia-react'
import {Box, createTheme, ThemeProvider} from "@mui/material";
import {blueGrey, grey, orange, red} from "@mui/material/colors";

createInertiaApp({
    resolve: name => import(`./Pages/${name}`).then(module => module.default),
    setup({el, App, props}) {
        const theme = createTheme({
            palette: {
                primary: blueGrey,
                secondary: grey,
                error: red,
                warning: orange,
            }
        })


        render(<ThemeProvider theme={theme}>
            <Box display={'grid'} marginTop={'64px'} sx={{
                placeContent: 'center',
            }}>
                <App {...props} />
            </Box>
        </ThemeProvider> , el)
    },
}).then()