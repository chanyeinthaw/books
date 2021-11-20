import {Box, Button} from "@mui/material";
import React from "react";
import {ChevronLeftOutlined} from "@mui/icons-material";

export default function BookDetailLayout({ navigateBack = false, error, buttons, children }) {
    let navigationProps = navigateBack ? {
       onClick: () => window.history.back()
    } : { href: route('books.index') }

    return (
        <Box sx={{
            display: "grid",
            gridTemplateAreas: '"head head" "book detail"',
            gridGap: '16px'
        }}>
            <Box display={"grid"} gridArea={"head"} gridTemplateColumns={"1fr max-content max-content"} justifyContent={"end"} alignContent={"end"} gap={"16px"}>
                <Button {...navigationProps} variant={'text'} startIcon={<ChevronLeftOutlined />} color={"primary"} size={"small"} sx={{
                    justifySelf: 'start'
                }}>{ navigateBack ? 'Back' : 'Books' }</Button>
                { !error && <>
                    { buttons.map((Btn, i) => {
                        return <React.Fragment key={i}>
                            { Btn }
                        </React.Fragment>
                    })}
                </>}
            </Box>
            { children }
        </Box>
    )
}