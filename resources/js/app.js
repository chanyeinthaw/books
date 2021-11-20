import React from 'react'
import { render } from 'react-dom'
import { createInertiaApp } from '@inertiajs/inertia-react'
import {Box, createTheme, IconButton, ThemeProvider} from "@mui/material";
import {blueGrey, grey, orange, red} from "@mui/material/colors";
import {SnackbarProvider} from "notistack";
import {CloseOutlined} from "@mui/icons-material";

createInertiaApp({
    resolve: name => import(`./Pages/${name}`).then(module => module.default),
    setup({el, App, props}) {
        const notificationStackRef = React.createRef()
        const theme = createTheme({
            palette: {
                primary: blueGrey,
                secondary: grey,
                error: red,
                warning: orange,
                white: {
                    main: grey["50"]
                }
            }
        })

        const onClickDismiss = key => () => {
            notificationStackRef.current?.closeSnackbar?.(key);
        }


        render(<ThemeProvider theme={theme}>
            <SnackbarProvider
                ref={notificationStackRef}
                action={(key) => (
                    <IconButton onClick={onClickDismiss(key)} color={"white"}>
                        <CloseOutlined />
                    </IconButton>
                )}
                autoHideDuration={3000}
                anchorOrigin={{
                    vertical: 'bottom',
                    horizontal: 'right'
                }}
                maxSnack={10}>
                <Box display={'grid'} marginTop={'64px'} sx={{
                    placeContent: 'center',
                }}>
                    <App {...props} />
                </Box>
            </SnackbarProvider>
        </ThemeProvider> , el)
    },
}).then()